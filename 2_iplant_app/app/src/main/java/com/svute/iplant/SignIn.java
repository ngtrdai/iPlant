package com.svute.iplant;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Parcelable;
import android.text.method.HideReturnsTransformationMethod;
import android.text.method.PasswordTransformationMethod;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class SignIn extends AppCompatActivity {

    TextView txtSignUp;
    EditText edtUserName, edtPass;
    Button btnSignIn;
    boolean passVisiable;
    UserIplant userIplant = new UserIplant();

    String userErr, loginErr, passErr, err, userName, userAcc, userImage;
    private static final String url = "https://iplant.svute.com/api/users/login_app.php";
    private final String urlGet = "https://iplant.svute.com/api/plants/getValue.php?act=countPlants&username=";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_in);
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);


        addControls();
        SessionManager sessionManager = new SessionManager(this);
        addEvents(sessionManager);
        setShowPass();
        checkLoginUser(sessionManager);
    }

    private void checkLoginUser(SessionManager sessionManager) {
        HashMap<String, String> user = sessionManager.getUserDetailFromSession();

        if(sessionManager.checkLogin()){
            sendDataUser(user.get(SessionManager.KEY_USER_ACC),user.get(SessionManager.KEY_USER_PASS));
        }
    }

    private void setShowPass() {
        edtPass.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                final int right =2;
                if(motionEvent.getAction() == MotionEvent.ACTION_UP){
                    if(motionEvent.getRawX() >= edtPass.getRight()-edtPass.getCompoundDrawables()[right].getBounds().width()){
                        int selection = edtPass.getSelectionEnd();
                        if(passVisiable){
                            //set Drawable here
                            edtPass.setCompoundDrawablesRelativeWithIntrinsicBounds(R.drawable.ic_lock,0,R.drawable.ic_eye_off,0);
                            //hide pass
                            edtPass.setTransformationMethod(PasswordTransformationMethod.getInstance());
                            passVisiable= false;
                        }else{
                            //set Drawable here
                            edtPass.setCompoundDrawablesRelativeWithIntrinsicBounds(R.drawable.ic_lock,0,R.drawable.ic_eye,0);
                            //hide pass
                            edtPass.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                            passVisiable= true;
                        }
                        edtPass.setSelection(selection);
                    }
                }
                return false;
            }
        });
    }

    private void addEvents(SessionManager sessionManager) {
        txtSignUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(SignIn.this,SignUp.class);
                startActivity(intent);
            }
        });
        btnSignIn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                sessionManager.createLoginSession(edtUserName.getText().toString(),edtPass.getText().toString());
                sendDataUser(edtUserName.getText().toString(),edtPass.getText().toString());
            }
        });
    }

    private void sendDataUser(String mUserName, String mPass) {
        StringRequest request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                xuLyJson(response);
                Log.d("ahihi", response);
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getApplicationContext(),"Disconectted DataBase",Toast.LENGTH_SHORT).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> map = new HashMap<String, String>();
                map.put("username",mUserName);
                map.put("password",mPass);
                return map;
            }
        };
        RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
        queue.add(request);
    }

    private void xuLyJson(String response) {
        try {
            JSONObject jsonObject = new JSONObject(response);
            userErr = jsonObject.getString("usernameErr");
            passErr = jsonObject.getString("passwordErr");
            loginErr = jsonObject.getString("loginErr");
            err = jsonObject.getString("err");
            userAcc = jsonObject.getString("username");
            userName= jsonObject.getString("fullname");
            userImage = jsonObject.getString("avatar_img");
            Log.d("ahuhu", userErr +"..."+ passErr +"..."+ loginErr+ "..."+ err+ "..."+ userAcc+ "..."+userName+ "..."+userImage);
            checkLogin(userErr,passErr,loginErr,err,userAcc,userName,userImage);
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void checkLogin(String userErr, String passErr, String loginErr, String err,String userAcc,String userName, String userImage) {
        if(!userErr.equals("")){
            Toast.makeText(this,userErr,Toast.LENGTH_SHORT).show();
        }
        if(!passErr.equals("")){
            Toast.makeText(this,passErr,Toast.LENGTH_SHORT).show();
        }
        if(!loginErr.equals("")){
            Toast.makeText(this,loginErr,Toast.LENGTH_SHORT).show();
        }
        if(!err.equals("")){
            Toast.makeText(this,err,Toast.LENGTH_SHORT).show();
            if(err.equals("Đăng nhập thành công.")){
                getNumIplants();
                userIplant.setUserAcc(userAcc);
                userIplant.setUserName(userName);
                userIplant.setUserImage(userImage);
                Handler h = new Handler();
                Runnable r1 = new Runnable() {
                    @Override
                    public void run() {
                        openHome();
                    }
                };
                h.postDelayed(r1, 200);
            }
        }
    }



    private void openHome() {
        Intent intent = new Intent(SignIn.this, MainActivity.class);
        intent.putExtra("userIplant", (Parcelable) userIplant);
        startActivity(intent);
        finish();

    }

    private void addControls() {
        txtSignUp = findViewById(R.id.txtCreateUser);
        edtUserName = findViewById(R.id.edtUserLogin);
        edtPass = findViewById(R.id.edtPassLogin);
        btnSignIn = findViewById(R.id.btnLogin);
    }

    private void getNumIplants(){
        StringRequest request = new StringRequest(Request.Method.POST, urlGet+userAcc, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                userIplant.setNumIplant(Integer.parseInt(response));
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                //displaying the error in toast if occurrs
            }
        });
        RequestQueue queue = Volley.newRequestQueue(this);
        queue.add(request);
    }



}