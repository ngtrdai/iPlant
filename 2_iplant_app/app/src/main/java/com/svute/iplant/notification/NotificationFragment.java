package com.svute.iplant.notification;

import android.os.Bundle;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
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
import com.svute.iplant.alarm.AlarmAdapter;
import com.svute.iplant.alarm.AlarmModel;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class NotificationFragment extends Fragment {

    RecyclerView recyclerView;
    NotiAdapter notiAdapter;
    SwipeRefreshLayout refreshLayout;
    List<NotiModel> notiModelList = new ArrayList<>();
    private String keyGetPutData = "userIplant";
    private final String urlNoti = "https://iplant.svute.com/api/controls/noti_app.php?act=getNotis&username=";
    UserIplant userIplant;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_notification, container, false);
        getUser();
        addControls(view);
        addEvents();
        getAlarmIplantDataBase(0);
        return view;
    }

    private void getUser() {
        Bundle args = getArguments();
        if (args != null) {
            userIplant = args.getParcelable(keyGetPutData);

        }
    }

    private void getAlarmIplantDataBase(int i) {
        StringRequest request = new StringRequest(Request.Method.POST, urlNoti+userIplant.getUserAcc(), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Log.d("TUG", response);
                xyLyJson(response,i);
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
            }
        });
        RequestQueue queue = Volley.newRequestQueue(getContext());
        queue.add(request);
    }

    private void xyLyJson(String response, int flag) {
        JSONArray jArray = null;
        try {
            // array [{value}:{value}]
            JSONObject js= new JSONObject(response);
            jArray = js.getJSONArray("data");
            JSONObject oneObject;

            notiModelList.clear();
            for (int i = 0; i < jArray.length(); i++) {
                oneObject = jArray.getJSONObject(i);
                notiModelList.add(new NotiModel(oneObject.getString("title"),oneObject.getString("content"),oneObject.getString("created_at"),oneObject.getString("img_url")));
                Log.d("XuLyJson", "xyLyJson: "+oneObject.getString("title"));
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
        switch (flag){
            case 0:
                showRecyclerView();
                break;
            case 1:
                showRecyclerViewReFresh();
                break;
        }
    }

    private void showRecyclerViewReFresh() {
        notiAdapter.setNotiAdapter(notiModelList);
        refreshLayout.setRefreshing(false);
    }

    private void showRecyclerView() {
        notiAdapter = new NotiAdapter();
        notiAdapter.setNotiAdapter(notiModelList);
        recyclerView.setAdapter(notiAdapter);
        recyclerView.setHasFixedSize(true);
    }

    private void addEvents() {
        refreshLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                refreshLayout.setRefreshing(true);
                refreshNoti();
            }
        });
    }

    private void refreshNoti() {
        notiModelList.clear();
        getAlarmIplantDataBase(1);
    }

    private void addControls(View view) {
        recyclerView = view.findViewById(R.id.recyclerViewNoti);
        refreshLayout = view.findViewById(R.id.swiperefreshlayoutNoti);
    }
}