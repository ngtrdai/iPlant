package com.svute.iplant.home;

import android.app.Dialog;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.Switch;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.github.mikephil.charting.charts.LineChart;
import com.github.mikephil.charting.components.XAxis;
import com.github.mikephil.charting.data.Entry;
import com.github.mikephil.charting.data.LineData;
import com.github.mikephil.charting.data.LineDataSet;
import com.github.mikephil.charting.interfaces.datasets.ILineDataSet;
import com.svute.iplant.R;
import com.svute.iplant.UserIplant;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class IplantDetailFragment extends Fragment {

    public static final String TAG = IplantDetailFragment.class.getName();

    TextView txtNameIplant;
    ImageButton btnBack, btnEdit;
    Button btnWater;
    Switch swLed,swUV;
    int checkLengData = 0;
    private LineChart lineChartSoil,lineChartLight,lineChartTemp;
    private String keyGetPutData = "userIplant";

    private static final String urlGet = "https://iplant.svute.com/api/plants/getValue.php?username=";
    private static final String urlEdit = "https://iplant.svute.com/api/plants/edit.php?username=";
    private static final String urlControl = "https://iplant.svute.com/api/plants/control.php?username=";

    private ArrayList<Entry> lineDataSoil = new ArrayList<>();
    private ArrayList<Entry> lineDataLight = new ArrayList<>();
    private ArrayList<Entry> lineDataTemp = new ArrayList<>();
    IplantModel iplantModel;
    UserIplant userIplant;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_iplant_detail, container, false);
        addControls(view);
        getDataFragment();
        addEvents();
        getStatusLed();
        setUpChart();
        DrawChart();
        return view;
    }

    private void getStatusLed() {
        StringRequest request = new StringRequest(Request.Method.POST, urlGet+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant()+"&act=getStatusLED", new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                //check value new -> update line chart
                xuLyJsonStatus(response);

            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                //displaying the error in toast if occurrs
                Toast.makeText(getActivity(), error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        try {
            RequestQueue queue = Volley.newRequestQueue(requireContext());
            queue.add(request);
        }catch (Exception e){

        }

    }

    private void xuLyJsonStatus(String response) {
        JSONArray jArray = null;
        try {
            // array [{value}:{value}]
            JSONObject js= new JSONObject(response);
           if(js.getString("is_led_noti").equals("1")){
               swLed.setChecked(true);
           }else{
               swLed.setChecked(false);
           }
            if(js.getString("is_led_uv").equals("1")){
                swUV.setChecked(true);
            }else{
                swUV.setChecked(false);
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void DrawChart() {
        new Thread(new Runnable() {
            @Override
            public void run() {
                do{
                    readDatabase();
                    try {
                        Thread.sleep(5000);
                    } catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                }while (isSafe());
            }
        }).start();
    }

    private boolean isSafe() {
        return !(this.isRemoving() || this.getActivity() == null || this.isDetached() || !this.isAdded() || this.getView() == null);
    }

    private void getDataFragment() {
        Bundle bundle = getArguments();
        if(bundle != null){
            iplantModel = (IplantModel) bundle.get("objectIplant");
            if(iplantModel != null){
                txtNameIplant.setText(iplantModel.getNameIplant());
            }
        }
    }

    private void addControls(View view) {
        txtNameIplant = view.findViewById(R.id.textViewNamePlant);
        btnBack = view.findViewById(R.id.imgButtonBack);
        btnEdit = view.findViewById(R.id.imageButtonEditNameIplantDetail);
        btnWater = view.findViewById(R.id.buttonWater);
        swLed = view.findViewById(R.id.switchLedIplant);
        swUV = view.findViewById(R.id.switchUVIplant);

        lineChartSoil = view.findViewById(R.id.linechartSoil);
        lineChartLight = view.findViewById(R.id.linechartLight);
        lineChartTemp = view.findViewById(R.id.linechartTemp);checkLengData = 0;
        Bundle args = getArguments();
        if (args != null) {
            userIplant = args.getParcelable(keyGetPutData);
            Log.d("TUG_userHome", userIplant.getUserName());
        }
    }

    private void addEvents() {
        btnBack.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(getFragmentManager() != null){
                    getFragmentManager().popBackStack();
                }

            }
        });
        btnEdit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                openDialogChangeName();
            }
        });
        btnWater.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                controlIplant(urlControl+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant()+"&act=pump");
            }
        });
        swLed.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
                if(swLed.isChecked()){
                    controlIplant(urlControl+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant()+"&act=turnLED"+"&toggle=on");
                }else{
                    controlIplant(urlControl+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant()+"&act=turnLED"+"&toggle=off");
                }
            }
        });

        swUV.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
                if(swUV.isChecked()){
                    controlIplant(urlControl+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant()+"&act=turnUV"+"&toggle=on");
                }else{
                    controlIplant(urlControl+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant()+"&act=turnUV"+"&toggle=off");
                }
            }
        });
    }

    private void controlIplant(String url) {
        StringRequest request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
            }
        });
        RequestQueue queue = Volley.newRequestQueue(getContext());
        queue.add(request);
    }

    private void openDialogChangeName() {
        final Dialog dialog = new Dialog(getContext());
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.dialog_change_name_iplant);

        Window window = dialog.getWindow();
        if(window == null){
            return;
        }
        window.setLayout(WindowManager.LayoutParams.MATCH_PARENT,WindowManager.LayoutParams.WRAP_CONTENT);
        window.setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));

        WindowManager.LayoutParams windowAtttibutes = window.getAttributes();
        windowAtttibutes.gravity = Gravity.CENTER;
        window.setAttributes(windowAtttibutes);

        if(Gravity.CENTER == Gravity.CENTER){
            dialog.setCancelable(true);
        }else {
            dialog.setCancelable(false);
        }

        Button btnConfirmChange = dialog.findViewById(R.id.buttonOkDialogControl);
        Button btnCancleChange = dialog.findViewById(R.id.buttonCancleDialogControl);
        EditText edtNameChange = dialog.findViewById(R.id.editTextDialogControlChangeName);
        ImageView imageView = dialog.findViewById(R.id.imageViewDialogChangeName);
        Spinner spinner = dialog.findViewById(R.id.appCompatSpinnerChange);

        ArrayAdapter<String> adapter =
                new ArrayAdapter<String>(getContext(),android.R.layout.simple_spinner_dropdown_item, getResources().getStringArray(R.array.imgList));
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);

        spinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
                switch (spinner.getSelectedItem().toString()){
                    case "Hình iPlant 1":
                        imageView.setImageResource(R.drawable.img_iplant_1);
                        break;
                    case "Hình iPlant 2":
                        imageView.setImageResource(R.drawable.img_iplant_2);
                        break;
                    case "Hình iPlant 3":
                        imageView.setImageResource(R.drawable.img_iplant_3);
                        break;
                    case "Hình iPlant 4":
                        imageView.setImageResource(R.drawable.img_iplant_4);
                        break;
                    case "Hình iPlant 5":
                        imageView.setImageResource(R.drawable.img_iplant_5);
                        break;
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });

        switch (iplantModel.getImgIplant()){
            case "img_iplant_1":
                spinner.setSelection(0);
                break;
            case "img_iplant_2":
                spinner.setSelection(1);
                break;
            case "img_iplant_3":
                spinner.setSelection(2);
                break;
            case "img_iplant_4":
                spinner.setSelection(3);
                break;
            case "img_iplant_5":
                spinner.setSelection(4);
                break;
        }
        edtNameChange.setHint(iplantModel.getNameIplant());
        btnConfirmChange.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                switch (spinner.getSelectedItem().toString()){
                    case "Hình iPlant 1":
                        sendNameEdit(edtNameChange.getText().toString(),"img_iplant_1");
                        break;
                    case "Hình iPlant 2":
                        sendNameEdit(edtNameChange.getText().toString(),"img_iplant_2");
                        break;
                    case "Hình iPlant 3":
                        sendNameEdit(edtNameChange.getText().toString(),"img_iplant_3");
                        break;
                    case "Hình iPlant 4":
                        sendNameEdit(edtNameChange.getText().toString(),"img_iplant_4");
                        break;
                    case "Hình iPlant 5":
                        sendNameEdit(edtNameChange.getText().toString(),"img_iplant_5");
                        break;
                }
                dialog.dismiss();
            }
        });

        btnCancleChange.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialog.dismiss();
            }
        });
        dialog.show();
    }

    private void sendNameEdit(String nameIplant, String imgIplant) {
        Log.d("ChangeName", "sendNameEdit: "+ urlEdit+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant());
        StringRequest request = new StringRequest(Request.Method.POST, urlEdit+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant(), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject jsonObject = new JSONObject(response);
                    String noti = jsonObject.getString("noti");
                    Toast.makeText(getContext(),noti,Toast.LENGTH_SHORT).show();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> map = new HashMap<String, String>();
                map.put("name",nameIplant);
                map.put("img_url",imgIplant);
                Log.d("ChangeName", "getParams: "+nameIplant);
                Log.d("ChangeName", "getParams: "+imgIplant);

                return map;
            }
        };
        RequestQueue queue = Volley.newRequestQueue(getContext());
        queue.add(request);
    }

    private void readDatabase() {
        StringRequest request = new StringRequest(Request.Method.POST, urlGet+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant()+"&act=getAll", new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                //check value new -> update line chart
                if(response.length() != checkLengData){
                    xuLyJson(response);
                }
                checkLengData = response.length();
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                //displaying the error in toast if occurrs
                Toast.makeText(getActivity(), error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        try {
            RequestQueue queue = Volley.newRequestQueue(requireContext());
            queue.add(request);
        }catch (Exception e){

        }

    }

    private void xuLyJson(String json) {
        JSONArray jArray = null;
        try {
            // array [{value}:{value}]
            JSONObject js= new JSONObject(json);
            jArray = js.getJSONArray("data");
            JSONObject oneObject;

            lineDataSoil.clear();
            lineDataLight.clear();
            lineDataTemp.clear();
            for (int i = 0; i < jArray.length(); i++) {
                oneObject = jArray.getJSONObject(i);
//                addEntry(xuLyDate(oneObject.getString("updated_at")),Float.parseFloat(oneObject.getString("soil_moisture")),Float.parseFloat(oneObject.getString("light_sensor")),Float.parseFloat(oneObject.getString("temperature_env")));

                addEntry(i,Float.parseFloat(oneObject.getString("soil_moisture")),Float.parseFloat(oneObject.getString("light_sensor")),Float.parseFloat(oneObject.getString("temperature_env")));
            }
            setUpLineC();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

//    private float xuLyDate(String updated_at) {
//
//        String[] valueDateAndTime = updated_at.split(" ");
//        String[] valueTime = valueDateAndTime[1].split(":");
//        int time = (Integer.parseInt(valueTime[0])*3600+Integer.parseInt(valueTime[1])*60+Integer.parseInt(valueTime[2]))*1000;
//        Log.e("TAG_Num", "xuLyDate: "+Integer.parseInt(valueTime[0])+Integer.parseInt(valueTime[1])+Integer.parseInt(valueTime[2]));
////        String time = valueDateAndTime[1].replaceAll(":","");
////        time = time.substring(0,time.length()-2);
//        Log.e("TAG", "xuLyDate: "+time);
//        return time;
//    }


    private void setUpChart() {
        lineChartSoil.getDescription().setEnabled(false);
        lineChartSoil.setPinchZoom(true);
        lineChartSoil.setScaleEnabled(true);
        lineChartSoil.setDrawGridBackground(false);
    }

    private void setUpLineC() {
        lineChartSoil.clear();
        lineChartLight.clear();
        lineChartTemp.clear();

        LineDataSet lineDataSetSoil = new LineDataSet(lineDataSoil,"Alpha X");
        LineDataSet lineDataSetLight = new LineDataSet(lineDataLight,"Alpha Y");
        LineDataSet lineDataSetTemp = new LineDataSet(lineDataTemp,"Alpha Z");

        lineDataSetSoil.setColor(Color.GREEN);
        lineDataSetLight.setColor(Color.RED);
        lineDataSetTemp.setColor(Color.BLUE);

        lineDataSetSoil.setLineWidth(5);
        lineDataSetLight.setLineWidth(5);
        lineDataSetTemp.setLineWidth(5);

        lineDataSetSoil.setValueTextSize(15f);
        lineDataSetLight.setValueTextSize(15f);
        lineDataSetTemp.setValueTextSize(15f);

        lineDataSetSoil.setMode(LineDataSet.Mode.HORIZONTAL_BEZIER);
        lineDataSetLight.setMode(LineDataSet.Mode.HORIZONTAL_BEZIER);
        lineDataSetTemp.setMode(LineDataSet.Mode.HORIZONTAL_BEZIER);

        ArrayList<ILineDataSet> iLineDataSetsSoil = new ArrayList<>();
        iLineDataSetsSoil.add(lineDataSetSoil);
        ArrayList<ILineDataSet> iLineDataSetsLight = new ArrayList<>();
        iLineDataSetsLight.add(lineDataSetLight);
        ArrayList<ILineDataSet> iLineDataSetsTemp = new ArrayList<>();
        iLineDataSetsTemp.add(lineDataSetTemp);

        LineData lineDataSoil = new LineData(iLineDataSetsSoil);
        lineChartSoil.setData(lineDataSoil);
        lineChartSoil.invalidate();
        LineData lineDataLight = new LineData(iLineDataSetsLight);
        lineChartLight.setData(lineDataLight);
        lineChartLight.invalidate();
        LineData lineDataTemp = new LineData(iLineDataSetsTemp);
        lineChartTemp.setData(lineDataTemp);
        lineChartTemp.invalidate();

//        XAxis xAxisSoild = lineChartSoil.getXAxis();
//        xAxisSoild.setValueFormatter(new DateAxisValueFormatter());
//
//        XAxis xAxisLight = lineChartLight.getXAxis();
//        xAxisLight.setValueFormatter(new DateAxisValueFormatter());
//
//        XAxis xAxisTemp = lineChartTemp.getXAxis();
//        xAxisTemp.setValueFormatter(new DateAxisValueFormatter());
    }

    private void addEntry(float id,float valX,float valY,float valZ){
        lineDataSoil.add(new Entry(id,valX));
        lineDataLight.add(new Entry(id,valY));
        lineDataTemp.add(new Entry(id,valZ));
        Log.d("data", String.valueOf(id));
    }
}