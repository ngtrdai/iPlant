package com.svute.iplant.alarm;

import android.app.DatePickerDialog;
import android.app.Dialog;
import android.app.TimePickerDialog;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.ItemTouchHelper;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.os.Handler;
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
import android.widget.DatePicker;
import android.widget.Spinner;
import android.widget.Switch;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.svute.iplant.R;
import com.svute.iplant.UserIplant;
import com.svute.iplant.home.IplantListData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Random;

public class AlarmFragment extends Fragment implements ItemTouchHelperListener{
    RecyclerView recyclerView;
    AlarmAdapter alarmAdapter;
    SwipeRefreshLayout refreshLayout;
    List<AlarmModel> alarmModelList = new ArrayList<>();
    Button btnOpenDialog;
    ArrayList<String> imeiArray = new ArrayList<>();
    ArrayList<String> nameArray = new ArrayList<>();
    UserIplant userIplant;
    private String keyGetPutData = "userIplant";

    private final String urlGetAlarm = "https://iplant.svute.com/api/controls/alarm.php?act=getAlarm";
    private final String urlAddAlarm = "https://iplant.svute.com/api/controls/alarm.php?act=add";
    private final String urlDeletAlarm = "https://iplant.svute.com/api/controls/alarm.php?act=delete&id=";
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_alarm, container, false);
        getUser();
        addControls(view);
        addMockData();
        addEvents();

        if (imeiArray.size() == 0){
            btnOpenDialog.setEnabled(false);
            alarmModelList.add(null);
            showRecyclerView();
        }else{
            getAlarmIplantDataBase(0);
        }

        return view;
    }

    private void getUser() {
        Bundle args = getArguments();
        if (args != null) {
            userIplant = args.getParcelable(keyGetPutData);
            Log.d("TUG_userHome", userIplant.getUserName());
        }
    }

    private void addControls(View view) {
        recyclerView = view.findViewById(R.id.recyclerViewControl);
        btnOpenDialog = view.findViewById(R.id.buttonOpenDialogAddControl);
        refreshLayout = view.findViewById(R.id.refreshControl);
    }

    private void addMockData() {
        imeiArray.clear();
        nameArray.clear();
        for (int i = 0; i < IplantListData.iplantList.size(); i++) {
            imeiArray.add(IplantListData.iplantList.get(i));
            nameArray.add(IplantListData.iplantNameList.get(i));
        }
    }

    private void addEvents() {
        btnOpenDialog.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Log.d("TAG_click_add_control", "onClick: ");
                openDialogAddAlarm();
            }
        });

        refreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                refreshAlarm();
            }
        });
    }

    private void refreshAlarm() {
        alarmModelList.clear();
        getAlarmIplantDataBase(1);
    }

    private void openDialogAddAlarm() {
        final Dialog dialog = new Dialog(getContext());
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.dialog_add_control);

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
        Spinner spinner = dialog.findViewById(R.id.spinnerIplant);
        Button btnAddAlarm = dialog.findViewById(R.id.buttonAddControl);
        Button btnCancleAlarm = dialog.findViewById(R.id.buttonCancleAddControl);
        TextView txtTimeAlarm = dialog.findViewById(R.id.textViewTimeDialogControl);
        TextView txtDateAlarm = dialog.findViewById(R.id.textViewDateDialogCotrol);
        TextView txtDataDate = dialog.findViewById(R.id.textViewDataDate);
        Switch swWater = dialog.findViewById(R.id.switchWater);
        Switch swUV = dialog.findViewById(R.id.switchUV);
        Switch swAuto = dialog.findViewById(R.id.switchAuto);

        SimpleDateFormat formatter = new SimpleDateFormat("dd-MM-yyyy");
        Date date = new Date();
        txtDateAlarm.setText(formatter.format(date));

        ArrayAdapter<String> adapter =
                new ArrayAdapter<String>(getContext(),android.R.layout.simple_spinner_dropdown_item, nameArray);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner.setAdapter(adapter);


        txtTimeAlarm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                setTime();
            }

            private void setTime() {
                Calendar calendar = Calendar.getInstance();
                int hour=calendar.get(Calendar.HOUR);
                int min=calendar.get(Calendar.MINUTE);

                TimePickerDialog timePickerDialog = new TimePickerDialog(getContext(), new TimePickerDialog.OnTimeSetListener() {
                    @Override
                    public void onTimeSet(TimePicker timePicker, int i, int i1) {
                        String mHour = i+"";
                        String mMin = i1+"";
                        if(i <= 9){
                            mHour = "0"+mHour;
                        }
                        if(i1 <= 9){
                            mMin = "0"+mMin;
                        }
                        txtTimeAlarm.setText(mHour+":"+mMin);
                    }
                },hour,min,true);

                timePickerDialog.show();
            }
        });
        txtDateAlarm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                setDate();
            }

            private void setDate() {
                Calendar calendar = Calendar.getInstance();
                int year = calendar.get(Calendar.YEAR);
                int month=calendar.get(Calendar.MONTH);
                int date= calendar.get(Calendar.DATE);

                DatePickerDialog datePickerDialog = new DatePickerDialog(getContext(), new DatePickerDialog.OnDateSetListener() {
                    @Override
                    public void onDateSet(DatePicker datePicker, int i, int i1, int i2) {
                        txtDateAlarm.setText(i2+"-"+(i1+1)+"-"+i);
                        txtDataDate.setText(i+"-"+(i1+1)+"-"+i2);
                    }
                },year,month,date);

                datePickerDialog.show();
            }
        });


        btnAddAlarm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String strSwWater, strSwUV, strSwAuto;
                if (swWater.isChecked())
                    strSwWater = swWater.getTextOn().toString();
                else
                    strSwWater = swWater.getTextOff().toString();
                if (swUV.isChecked())
                    strSwUV = swUV.getTextOn().toString();
                else
                    strSwUV = swUV.getTextOff().toString();
                if (swAuto.isChecked())
                    strSwAuto = swAuto.getTextOn().toString();
                else
                    strSwAuto = swAuto.getTextOff().toString();

                addAlarmDataBase(spinner.getSelectedItemPosition(),txtDataDate.getText().toString(),txtTimeAlarm.getText().toString(),strSwWater,strSwUV,strSwAuto);
                Handler handler = new Handler();
                handler.postDelayed(new Runnable() {
                    @Override
                    public void run() {
                        refreshLayout.setRefreshing(true);
                        refreshAlarm();
                    }
                },300);
                dialog.dismiss();
            }
        });

        btnCancleAlarm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                dialog.dismiss();
            }
        });

        dialog.show();
    }

    private void addAlarmDataBase(int selectedItemPosition, String date, String time, String textSwWater, String textSwUv, String toggleEveryday) {
        StringRequest request = new StringRequest(Request.Method.POST, urlAddAlarm, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.d("TUG", response);
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
                map.put("imei",imeiArray.get(selectedItemPosition));
                map.put("set_time",date+"T"+time+":00");
                map.put("flag_loop",toggleEveryday);
                map.put("flag_pump",textSwWater);
                map.put("flag_uv",textSwUv);
                Log.d("Flag", textSwWater+" "+textSwUv);
                return map;
            }
        };
        RequestQueue queue = Volley.newRequestQueue(getContext());
        queue.add(request);
    }

    private void getAlarmIplantDataBase(int flag) {
        for (int i = 0; i < imeiArray.size(); i++) {
            int indexImei = i;
            Random r = new Random();
            int red=r.nextInt(255 - 0 + 1)+0;
            int green=r.nextInt(255 - 0 + 1)+0;
            int blue=r.nextInt(255 - 0 + 1)+0;
            StringRequest request = new StringRequest(Request.Method.POST, urlGetAlarm, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("TAG", response);
                    xuLyJson(response,red,green,blue,flag);
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
                    map.put("imei",imeiArray.get(indexImei));
                    return map;
                }
            };
            RequestQueue queue = Volley.newRequestQueue(getContext());
            queue.add(request);
        }
    }

    private void xuLyJson(String response, int red, int green, int blue, int flag) {
        JSONArray jArray = null;
        try {
            Log.d("TAG", "Vo xu ly rui ne");
            jArray = new JSONArray(response);
            JSONObject oneObject;
            for (int i = 0; i < jArray.length(); i++) {
                oneObject = jArray.getJSONObject(i);
                Log.d("alarm", oneObject.getInt("id")+" "+
                        oneObject.getString("date")+" "+
                        oneObject.getString("name")+" "+
                        oneObject.getString("img_url")+" "+
                        oneObject.getString("hour")+" "+
                        oneObject.getString("minute")+" "+
                        red+" "+
                        green+" "+
                        blue+" "+
                        oneObject.getInt("flag_pump")+" "+
                        oneObject.getInt("flag_uv")+" "+
                        oneObject.getInt("flag_loop"));
                alarmModelList.add(new AlarmModel(oneObject.getInt("id"),
                        oneObject.getString("date"),
                        oneObject.getString("name"),
                        oneObject.getString("img_url"),
                        oneObject.getString("hour"),
                        oneObject.getString("minute"),
                        red,
                        green,
                        blue,
                        oneObject.getInt("flag_pump"),
                        oneObject.getInt("flag_uv"),
                        oneObject.getInt("flag_loop"),
                        getContext()));
            }
            Log.d("TAG_model", alarmModelList.size()+"");
            switch (flag){
                case 0:
                    showRecyclerView();
                    break;
                case 1:
                    showRecyclerViewReFresh();
                    break;
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void onSwiped(RecyclerView.ViewHolder viewHolder) {
        if(viewHolder instanceof AlarmAdapter.AlarmViewHolder){
            String alarmName = alarmModelList.get(viewHolder.getAdapterPosition()).getIplantName();
            AlarmModel alarmModel = alarmModelList.get(viewHolder.getAdapterPosition());
            int indexDelete = viewHolder.getAdapterPosition();
            int idAlarmDelete = alarmModelList.get(viewHolder.getAdapterPosition()).getId();
            alarmAdapter.removeAlarm(indexDelete);
            deleteAlarmDataBase(idAlarmDelete,alarmModel,indexDelete);
        }
    }

    private void deleteAlarmDataBase(int idAlarmDelete, AlarmModel alarModel, int indexDelete) {
        final Dialog dialog = new Dialog(getContext());
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.dialog_confirm_delete_alarm);

        Window window = dialog.getWindow();
        if(window == null){
            return;
        }
        window.setLayout(WindowManager.LayoutParams.MATCH_PARENT,WindowManager.LayoutParams.WRAP_CONTENT);
        window.setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));

        WindowManager.LayoutParams windowAtttibutes = window.getAttributes();
        windowAtttibutes.gravity = Gravity.CENTER;
        window.setAttributes(windowAtttibutes);
        dialog.setCancelable(false);

        Button btnConfirmAlarm = dialog.findViewById(R.id.buttonDeleteDialogConfirm);
        Button btnCancleAlarm = dialog.findViewById(R.id.buttonCancleDialogConfirm);
        TextView txtNameDialog = dialog.findViewById(R.id.textViewNameDiaologDelete);

        txtNameDialog.setText("Xoá thời gian tưới");
        btnConfirmAlarm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                sendDelete(idAlarmDelete);
                refreshAlarm();
                dialog.dismiss();
            }
        });
        btnCancleAlarm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                alarmAdapter.undoAlarm(alarModel,indexDelete);
                dialog.dismiss();
            }
        });

        dialog.show();

    }

    private void sendDelete(int idAlarmDelete) {
        StringRequest request = new StringRequest(Request.Method.POST, urlDeletAlarm+idAlarmDelete, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.d("TUG", response);
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
        });
        RequestQueue queue = Volley.newRequestQueue(getContext());
        queue.add(request);
    }

    private void showRecyclerView(){
        alarmAdapter = new AlarmAdapter();
        Log.d("TAG_recycler", alarmModelList.size()+"");
        alarmAdapter.setDataAlarmAdapter(alarmModelList);
        recyclerView.setAdapter(alarmAdapter);
        recyclerView.setHasFixedSize(true);
        ItemTouchHelper.SimpleCallback simpleCallback = new RecyclerViewItemTouchHelper(0,ItemTouchHelper.LEFT, this);
        new ItemTouchHelper(simpleCallback).attachToRecyclerView(recyclerView);
    }

    private void showRecyclerViewReFresh(){
        alarmAdapter.setDataAlarmAdapter(alarmModelList);
        refreshLayout.setRefreshing(false);
    }
}