package com.svute.iplant.add;

import android.Manifest;
import android.app.Dialog;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;

import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.budiyev.android.codescanner.CodeScanner;
import com.budiyev.android.codescanner.CodeScannerView;
import com.budiyev.android.codescanner.DecodeCallback;
import com.budiyev.android.codescanner.ScanMode;
import com.google.zxing.Result;
import com.svute.iplant.R;
import com.svute.iplant.UserIplant;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class AddIplantFragment extends Fragment {

    private EditText codeData;
    private Button btnAdd;
    private CodeScannerView scannerView;
    private UserIplant userIplant;
    private String keyGetPutData = "userIplant";
    private CodeScanner mCodeScanner;
    private String noti;
    private final String urlAdd = "https://iplant.svute.com/api/plants/add.php?act=add&username=";
    private String url = "https://iplant.svute.com/api/plants/getValue.php?act=sensors&imei=";

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_add_iplant, container, false);
        getUser();
        addControls(view);
        addEvents();
        checkPermissionCamera();
        return view;
    }

    private void getUser() {
        Bundle getUser = getArguments();
        if(getUser != null){
            userIplant = getUser.getParcelable(keyGetPutData);
        }
    }

    private void addEvents() {
        btnAdd.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                sendAddIplantDataBase(codeData.getText().toString());
            }
        });

        mCodeScanner = new CodeScanner(getContext(), scannerView);
        mCodeScanner.setAutoFocusEnabled(true);
        mCodeScanner.setFormats(CodeScanner.ALL_FORMATS);
        mCodeScanner.setScanMode(ScanMode.CONTINUOUS);
        mCodeScanner.startPreview();
        mCodeScanner.setDecodeCallback(new DecodeCallback() {
            @Override
            public void onDecoded(@NonNull Result result) {
                getActivity().runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        getNameIplant(result.getText());
                    }
                });
            }
        });
    }

    private void getNameIplant(String imei) {
        StringRequest request = new StringRequest(Request.Method.POST, url+ imei, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONArray jArray = null;
                try {
                    JSONObject jsonObject = new JSONObject(response);
                    jArray = (JSONArray) jsonObject.get("value");
                    String nameIplant = jsonObject.get("name").toString();
                    openDialogAdd(imei,nameIplant);
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

    private void checkPermissionCamera() {
        if(ContextCompat.checkSelfPermission(getContext(), Manifest.permission.CAMERA) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(getActivity(), new String[]{
                    Manifest.permission.CAMERA
            },1);
        }
    }

    private void addControls(View view) {
        codeData = view.findViewById(R.id.editTextTextImei);
        btnAdd = view.findViewById(R.id.buttonAdd);
        scannerView = view.findViewById(R.id.scanner_view);
    }
    private void openDialogAdd(String imei, String nameIplant) {
        mCodeScanner.releaseResources();
        final Dialog dialog= new Dialog(getContext());
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setContentView(R.layout.dialog_add_iplant);

        Window window = dialog.getWindow();
        if(window == null){
            return;
        }

        window.setLayout(WindowManager.LayoutParams.MATCH_PARENT,WindowManager.LayoutParams.WRAP_CONTENT);
        window.setBackgroundDrawable(new ColorDrawable(Color.TRANSPARENT));

        WindowManager.LayoutParams windowAtttibutes = window.getAttributes();
        windowAtttibutes.gravity = Gravity.CENTER;
        window.setAttributes(windowAtttibutes);

//        //xu ly click outside
//        if(Gravity.CENTER == Gravity.CENTER){
//            dialog.setCancelable(true);
//        }else {
//            dialog.setCancelable(false);
//        }
        dialog.setCancelable(false);

        TextView txtName = dialog.findViewById(R.id.editTextDialogControlChangeName);
        TextView txtImei = dialog.findViewById(R.id.textViewImeiDialogChangeName);
        ImageView imageView = dialog.findViewById(R.id.imageViewDialogChangeName);
        Button btnOK = dialog.findViewById(R.id.buttonOkDialogControl);
        Button btnCancle = dialog.findViewById(R.id.buttonCancleDialogControl);

        txtName.setText(nameIplant);
        txtImei.setText(imei);
        btnOK.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                sendAddIplantDataBase(imei);
                mCodeScanner.startPreview();
                dialog.dismiss();
            }
        });
        btnCancle.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                mCodeScanner.startPreview();
                dialog.dismiss();
            }
        });
        dialog.show();
    }

    @Override
    public void onResume() {
        super.onResume();
        mCodeScanner.startPreview();
    }

    @Override
    public void onPause() {
        mCodeScanner.releaseResources();
        super.onPause();
    }

    private void sendAddIplantDataBase(String result) {
        StringRequest request = new StringRequest(Request.Method.POST, urlAdd+userIplant.getUserAcc(), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONObject jsonObject = new JSONObject(response);
                    noti = jsonObject.getString("noti");
                    Toast.makeText(getContext(),noti,Toast.LENGTH_SHORT).show();
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getContext(),"that bai",Toast.LENGTH_LONG).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> map = new HashMap<String, String>();
                map.put("imei",result);
                return map;
            }
        };
        RequestQueue queue = Volley.newRequestQueue(getContext());
        queue.add(request);
    }
}