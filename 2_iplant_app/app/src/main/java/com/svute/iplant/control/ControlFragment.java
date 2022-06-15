package com.svute.iplant.control;

import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.ItemTouchHelper;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.svute.iplant.R;
import com.svute.iplant.UserIplant;
import com.svute.iplant.alarm.AlarmAdapter;
import com.svute.iplant.alarm.RecyclerViewItemTouchHelper;
import com.svute.iplant.home.IplantListData;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Random;

public class ControlFragment extends Fragment {
    RecyclerView recyclerView;
    ControlAdapter controlAdapter;
    SwipeRefreshLayout refreshLayout;
    List<ControlModel> controlModelList = new ArrayList<>();

    ArrayList<String> imeiArray = new ArrayList<>();
    ArrayList<String> nameArray = new ArrayList<>();
    ArrayList<String> imgArray = new ArrayList<>();
    private String keyGetPutData = "userIplant";
    UserIplant userIplant;

    private final String urlControlEdit = "https://iplant.svute.com/api/controls/auto.php?act=edit";
    private final String urlControlGet = "https://iplant.svute.com/api/controls/auto.php?act=getAuto&imei=";
    private final String urlControlToggle = "https://iplant.svute.com/api/controls/auto.php?act=toggle&username=";


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_control, container, false);
        getUser();
        addControls(view);
        addMockData();
        addEvents();

        if (imeiArray.size() == 0){
            controlModelList.add(null);
            showRecyclerView();
        }else{
            getControlIplantDataBase(0);
        }
        
        return view;
    }

    private void getControlIplantDataBase(int flag) {
        for (int i = 0; i < imeiArray.size(); i++) {
            int indexIplant = i;
            StringRequest request = new StringRequest(Request.Method.POST, urlControlGet+imeiArray.get(i), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("VietControl", response);
                    Log.d("VietControl", urlControlGet+imeiArray.get(indexIplant));
                    xuLyJson(response,flag,indexIplant);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                }
            });
            RequestQueue queue = Volley.newRequestQueue(getContext());
            queue.add(request);
        }
    }

    private void xuLyJson(String response, int flag, int indexIplant) {
        JSONArray jArray = null;
        try {
            jArray = new JSONArray(response);
            JSONObject oneObject;
                Log.d("TUG_imei",  "Null");
                for (int i = 0; i < jArray.length(); i++) {
                oneObject = jArray.getJSONObject(i);
                controlModelList.add(new ControlModel(nameArray.get(indexIplant),
                        imgArray.get(indexIplant),
                        oneObject.getInt("soil_moisture"),
                        oneObject.getInt("light_sensor"),
                        oneObject.getInt("temperature_env"),
                        oneObject.getInt("status"),
                        oneObject.getString("imei"),getContext()));

                }
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



    private void showRecyclerView() {
        controlAdapter = new ControlAdapter();
        controlAdapter.setControlAdapter(controlModelList);
        recyclerView.setAdapter(controlAdapter);
        recyclerView.setHasFixedSize(true);
//        ItemTouchHelper.SimpleCallback simpleCallback = new RecyclerViewItemTouchHelper(0,ItemTouchHelper.LEFT, this);
//        new ItemTouchHelper(simpleCallback).attachToRecyclerView(recyclerView);
    }
    private void showRecyclerViewReFresh(){
        controlAdapter.setControlAdapter(controlModelList);
        refreshLayout.setRefreshing(false);
    }

    private void getUser() {
        Bundle args = getArguments();
        if (args != null) {
            userIplant = args.getParcelable(keyGetPutData);
            Log.d("TUG_userHome", userIplant.getUserName());
        }
    }

    private void addControls(View view) {
        recyclerView = view.findViewById(R.id.recyclerControl);
        refreshLayout = view.findViewById(R.id.refreshLayoutControl);
    }

    private void addMockData() {
        imeiArray.clear();
        nameArray.clear();
        imgArray.clear();
        for (int i = 0; i < IplantListData.iplantList.size(); i++) {
            imeiArray.add(IplantListData.iplantList.get(i));
            nameArray.add(IplantListData.iplantNameList.get(i));
            imgArray.add(IplantListData.iplantImgList.get(i));
        }
    }

    private void addEvents() {
        refreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                controlModelList.clear();
                getControlIplantDataBase(1);
            }
        });
    }

}