package com.svute.iplant.home;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.os.Handler;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.svute.iplant.R;
import com.svute.iplant.UserIplant;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class LoadWaitFragment extends Fragment {

    private String url = "https://iplant.svute.com/api/plants/getValue.php?act=sensors&imei=";
    private final String urlGetImei = "https://iplant.svute.com/api/plants/getValue.php?act=getMyPlants&username=";
    private UserIplant userIplant;
    private String keyGetPutData = "userIplant";
    private String keySendPutData = "userIplant";
    AppCompatActivity activity;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_load_wait, container, false);
        activity = (AppCompatActivity) view.getContext();
        getUserIplant();
        getImeiIplant();


        return view;
    }

    private void getUserIplant() {
        Bundle bundle = getArguments();
        if(bundle != null){
            userIplant = (UserIplant) bundle.getParcelable(keyGetPutData);
            Log.d("TUG_User_loadwait", userIplant.getUserName());
        }
    }

    private void setIplantModel() {
        for (int i = 0; i < IplantListData.iplantList.size(); i++) {
            StringRequest request = new StringRequest(Request.Method.POST, url+ IplantListData.iplantList.get(i), new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("TUG_IplantModel", response);
                    IplantListData.responeIplant.add(response);
                    if(IplantListData.responeIplant.size() == IplantListData.iplantList.size()){
                        startActivity();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    //displaying the error in toast if occurrs
                }
            });
            RequestQueue queue = Volley.newRequestQueue(getContext());
            queue.add(request);
        }
        Log.d("TUG_IplantModel", String.valueOf(IplantListData.responeIplant.size()));
    }

    private void getImeiIplant() {
        StringRequest request = new StringRequest(Request.Method.POST, urlGetImei+ userIplant.getUserAcc(), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                xuLyJsonImei(response);
                Log.d("TUG_GetImei", "Done");
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                //displaying the error in toast if occurrs
            }
        });
        RequestQueue queue = Volley.newRequestQueue(getContext());
        queue.add(request);
    }

    private void xuLyJsonImei(String response) {
        JSONArray jArray = null;
        try {
            jArray = new JSONArray(response);
            JSONObject oneObject;
            IplantListData.iplantList.clear();
            for (int i = 0; i < jArray.length(); i++) {
                oneObject = jArray.getJSONObject(i);
                IplantListData.iplantList.add(oneObject.getString("imei"));
            }
            Log.d("TUG_imei",  IplantListData.iplantList.toString());
            Log.d("TUG_imei", String.valueOf(IplantListData.iplantList.size()));
            setIplantModel();
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void startActivity(){
        Log.d("TAG", "DONE");
        Fragment homeFragment = new HomeFragment();
        Bundle bundle = new Bundle();
        bundle.putParcelable(keySendPutData,userIplant);
        homeFragment.setArguments(bundle);
        activity.getSupportFragmentManager().beginTransaction().replace(R.id.frameLayout, homeFragment).addToBackStack(null).commit();
    }


}