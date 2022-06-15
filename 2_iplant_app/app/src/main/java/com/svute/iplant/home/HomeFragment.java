package com.svute.iplant.home;

import android.app.Dialog;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.ItemTouchHelper;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.svute.iplant.MainActivity;
import com.svute.iplant.R;
import com.svute.iplant.UserIplant;
import com.svute.iplant.home.ItemTouchHelperListener;
import com.svute.iplant.home.RecyclerViewItemTouchHelper;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.List;


public class HomeFragment extends Fragment implements ItemTouchHelperListener {
    RecyclerView recyclerView;
    IplantAdapter iplantAdapter;
    List<IplantModel> iplantModelList = new ArrayList<>();
    private UserIplant userIplant;
    private String keyGetPutData = "userIplant";
    AppCompatActivity activity;

    private String url = "https://iplant.svute.com/api/plants/getValue.php?act=sensors&imei=";
    private final String urlGetImei = "https://iplant.svute.com/api/plants/getValue.php?act=getMyPlants&username=";
    private final String urlDeleteIplant = "https://iplant.svute.com/api/plants/delete.php?username=";
    private MainActivity mMainActivity;
    private SwipeRefreshLayout swipeRefreshLayout;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_home, container, false);
        addControls(view);
        getUserIplant();
        addEvents();
        iplantAdapter = new IplantAdapter();
        iplantAdapter.setIplantAdapter(iplantModelList, new IplantAdapter.IClickItemListener() {
            @Override
            public void onClickItemIplant(IplantModel iplantModel) {
                mMainActivity.openIplantDetailFragment(iplantModel);
            }
        });
        recyclerView.setAdapter(iplantAdapter);
        recyclerView.setHasFixedSize(true);
        ItemTouchHelper.SimpleCallback simpleCallback = new RecyclerViewItemTouchHelper(0,ItemTouchHelper.LEFT, this);
        new ItemTouchHelper(simpleCallback).attachToRecyclerView(recyclerView);
        addData();
        return view;
    }

    private void addData() {
        swipeRefreshLayout.setRefreshing(true);
        IplantListData.responeIplant.clear();
        IplantListData.iplantList.clear();
        IplantListData.iplantNameList.clear();
        IplantListData.iplantImgList.clear();
        iplantModelList.clear();
        getImeiIplant();
    }

    private void addEvents() {
        swipeRefreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                addData();
                Log.d("TqG_iplantModelList", iplantModelList.size()+"");
                Log.d("TqG_iplantList", IplantListData.iplantList.size()+"");
                Log.d("TqG_responeIplant", IplantListData.responeIplant.size()+"");
            }
        });

    }

    private void addControls(View view) {
        activity = (AppCompatActivity) view.getContext();
        mMainActivity = (MainActivity) getActivity();
        recyclerView = view.findViewById(R.id.recyclerView);
        swipeRefreshLayout = view.findViewById(R.id.swiperefreshlayout);
    }

    private void getUserIplant() {
        Bundle bundle = getArguments();
        if(bundle != null){
            userIplant = (UserIplant) bundle.getParcelable(keyGetPutData);
            Log.d("TUG_User_loadwait", userIplant.getUserName());
        }
    }

    private void getImeiIplant() {
        IplantListData.iplantList.clear();
        StringRequest request = new StringRequest(Request.Method.POST, urlGetImei+ userIplant.getUserAcc(), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.d("TqG_GetImei", response);
                xuLyJsonImei(response);
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                //displaying the error in toast if occurrs
            }
        });
        RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
        queue.add(request);
    }

    private void xuLyJsonImei(String response) {
        JSONArray jArray = null;
        try {
            jArray = new JSONArray(response);
            JSONObject oneObject;
            if (jArray.length() == 0){
                xuLyNullData();
                Log.d("TUG_imei",  "Null");
            }else {
                for (int i = 0; i < jArray.length(); i++) {
                    oneObject = jArray.getJSONObject(i);
                    IplantListData.iplantList.add(oneObject.getString("imei"));
                }
                Log.d("TUG_imei",  IplantListData.iplantList.toString());
                setIplantModel();
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void xuLyNullData() {
        swipeRefreshLayout.setRefreshing(false);
        iplantModelList.add(new IplantModel("Null"));
        iplantModelList.add(null);
        iplantAdapter.setIplantAdapter(iplantModelList);
    }

    private void setIplantModel() {
        for (int i = 0; i < IplantListData.iplantList.size(); i++) {
            StringRequest request = new StringRequest(Request.Method.POST, url+ IplantListData.iplantList.get(i), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("TqG_IplantModel", response);
                    IplantListData.responeIplant.add(response);
                    if(IplantListData.responeIplant.size() == IplantListData.iplantList.size()){
                        xuLyJsonIplantModel();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //displaying the error in toast if occurrs
                }
            });
            RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
            queue.add(request);
        }
        Log.d("TUG_IplantModel", String.valueOf(IplantListData.responeIplant.size()));
    }

    private void xuLyJsonIplantModel() {
        for (int i = 0; i < IplantListData.responeIplant.size(); i++) {
            JSONArray jArray = null;
            try {
                JSONObject jsonObject = new JSONObject(IplantListData.responeIplant.get(i));
                jArray = (JSONArray) jsonObject.get("value");
                String nameIplant = jsonObject.get("name").toString();
                JSONObject oneObject;
                oneObject = jArray.getJSONObject(jArray.length()-1);
                Log.d("TqG_IplantMode", oneObject.getString("soil_moisture") + " " + oneObject.getString("temperature_env")+ " " +oneObject.getString("light_sensor")+ " " +oneObject.getString("water_level"));
                iplantModelList.add(new IplantModel(oneObject.getString("imei")
                        ,(String) jsonObject.get("name")
                        ,jsonObject.getString("img_url")
                        ,oneObject.getString("soil_moisture")
                        ,oneObject.getString("temperature_env")
                        ,oneObject.getString("light_sensor")
                        ,xyLyWater(oneObject.getString("water_level"))));
                IplantListData.iplantNameList.add(jsonObject.getString("name"));
                IplantListData.iplantImgList.add(jsonObject.getString("img_url"));
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
        iplantModelList.add(null);
        setUpRecyclerView();
        swipeRefreshLayout.setRefreshing(false);

    }

    private void setUpRecyclerView() {
        iplantAdapter.setIplantAdapter(iplantModelList, new IplantAdapter.IClickItemListener() {
            @Override
            public void onClickItemIplant(IplantModel iplantModel) {
                mMainActivity.openIplantDetailFragment(iplantModel);
            }
        });
    }

    private String xyLyWater(String water_level) {
        switch (water_level){
            case "low":
                return "25";
            case "medium":
                return "70";
            case "warning":
                return "10";
            case "full":
                return "100";
        }
        return "0";
    }

    @Override
    public void onSwiped(RecyclerView.ViewHolder viewHolder) {
        if(viewHolder instanceof IplantAdapter.iplantViewHolder){
            String iplantName = iplantModelList.get(viewHolder.getAdapterPosition()).getNameIplant();
            IplantModel iplantModel = iplantModelList.get(viewHolder.getAdapterPosition());
            int indexDelete = viewHolder.getAdapterPosition();
            String idIplantDelete = iplantModelList.get(viewHolder.getAdapterPosition()).getImeiIplant();
            iplantAdapter.removeIplant(indexDelete);
            openDialogConfirmDelete(iplantModel,indexDelete);
        }
    }
    private void openDialogConfirmDelete(IplantModel iplantModel, int indexDelete) {
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

        txtNameDialog.setText("Xoá iPlant");
        btnConfirmAlarm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                deleteIplantDataBase(iplantModel);
                dialog.dismiss();
            }
        });
        btnCancleAlarm.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                iplantAdapter.undoIplant(iplantModel,indexDelete);
                dialog.dismiss();
            }
        });

        dialog.show();
    }
    private void deleteIplantDataBase(IplantModel iplantModel) {
        StringRequest request = new StringRequest(Request.Method.POST, urlDeleteIplant+userIplant.getUserAcc()+"&imei="+iplantModel.getImeiIplant(), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.d("TqG_IplantModel", response);
                try {
                    JSONObject jsonObject = new JSONObject(response);
                    String noti = jsonObject.getString("noti");
                    addData();
                    Toast.makeText(getContext(),noti,Toast.LENGTH_SHORT).show();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                //displaying the error in toast if occurrs
            }
        });
        RequestQueue queue = Volley.newRequestQueue(getActivity().getApplicationContext());
        queue.add(request);
    }
}