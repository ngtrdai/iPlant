package com.svute.iplant;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import android.content.Intent;
import android.os.Bundle;
import android.text.method.HideReturnsTransformationMethod;
import android.text.method.PasswordTransformationMethod;
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

public class SignUp extends AppCompatActivity {

    private TextView txtLogin;
    private EditText edtUserName, edtPass, edtPassConfirm,edtFullName, edtMail;
    private Button btnSignUp;
    String userErr, pass1Err, pass2Err, fullNameErr, err;
    boolean passVisiable,passVisiable2;
    private static final String url = "https://iplant.svute.com/api/users/register.php";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_up);
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);


        addControls();
        addEvents();
        setShowPass();
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

        edtPassConfirm.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent motionEvent) {
                final int right =2;
                if(motionEvent.getAction() == MotionEvent.ACTION_UP){
                    if(motionEvent.getRawX() >= edtPassConfirm.getRight()-edtPassConfirm.getCompoundDrawables()[right].getBounds().width()){
                        int selection = edtPassConfirm.getSelectionEnd();
                        if(passVisiable2){
                            //set Drawable here
                            edtPassConfirm.setCompoundDrawablesRelativeWithIntrinsicBounds(0,0,R.drawable.ic_eye_off,0);
                            //hide pass
                            edtPassConfirm.setTransformationMethod(PasswordTransformationMethod.getInstance());
                            passVisiable2= false;
                        }else{
                            //set Drawable here
                            edtPassConfirm.setCompoundDrawablesRelativeWithIntrinsicBounds(0,0,R.drawable.ic_eye,0);
                            //hide pass
                            edtPassConfirm.setTransformationMethod(HideReturnsTransformationMethod.getInstance());
                            passVisiable2= true;
                        }
                        edtPassConfirm.setSelection(selection);
                    }
                }
                return false;
            }
        });
    }

    private void signUp(final String name,final String pass, final String passC,final String fullname,final String mail) {
        StringRequest request = new StringRequest(Request.Method.POST, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                xuLyJson(response);
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(getApplicationContext(),"that bai",Toast.LENGTH_LONG).show();
            }
        }){
            @Nullable
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String,String> map = new HashMap<String, String>();
                map.put("username",name);
                map.put("password1",pass);
                map.put("password2",passC);
                map.put("fullname",fullname);
                map.put("email",mail);
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
            pass1Err = jsonObject.getString("password1Err");
            pass2Err = jsonObject.getString("password2Err");
            fullNameErr = jsonObject.getString("fullnameErr");
            err = jsonObject.getString("err");
            checkSignUp(userErr,pass1Err,pass2Err,fullNameErr,err);
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    private void checkSignUp(String userErr, String pass1Err, String pass2Err, String fullNameErr, String err) {
        if(!userErr.equals("")){
            Toast.makeText(this,userErr,Toast.LENGTH_SHORT).show();
        }
        else if(!pass1Err.equals("")){
            Toast.makeText(this,pass1Err,Toast.LENGTH_SHORT).show();
        }
        else if(!pass2Err.equals("")){
            Toast.makeText(this,pass2Err,Toast.LENGTH_SHORT).show();
        }
        else if(!fullNameErr.equals("")){
            Toast.makeText(this,fullNameErr,Toast.LENGTH_SHORT).show();
        }
        else if(!err.equals("")){
            Toast.makeText(this,err,Toast.LENGTH_SHORT).show();
            if(err.equals("Tạo tài khoản thành công...")){
                Intent intent = new Intent(SignUp.this, SignIn.class);
                startActivity(intent);
                finish();
            }
        }
    }

    private void addControls(){
        txtLogin = findViewById(R.id.txtStarted);
        edtUserName = findViewById(R.id.edtUserNameSignUp);
        edtPass = findViewById(R.id.edtPassSignUp);
        edtPassConfirm = findViewById(R.id.edtConfirmPassSignUp);
        edtFullName = findViewById(R.id.edtFullNameSignUp);
        edtMail = findViewById(R.id.edtMailSignUp);
        btnSignUp = findViewById(R.id.btnSignUp);
    }

    private void addEvents(){
        txtLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(SignUp.this, SignIn.class);
                startActivity(intent);
                finish();
            }
        });

        btnSignUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                signUp(edtUserName.getText().toString(), edtPass.getText().toString(),edtPassConfirm.getText().toString(),edtFullName.getText().toString(), edtMail.getText().toString());
            }
        });
    }

}