package com.svute.iplant;

import android.content.Context;
import android.content.SharedPreferences;

import java.util.HashMap;

public class SessionManager {

    SharedPreferences userSession;
    SharedPreferences.Editor editor;
    Context context;

    private static final String KEY_IS_LOGIN = "IsLogin";
    public static final String KEY_USER_ACC = "userAcc";
    public static final String KEY_USER_PASS = "userPass";

    public SessionManager (Context context){
        this.context = context;
        userSession = context.getSharedPreferences("userLoginSession",Context.MODE_PRIVATE);
        editor = userSession.edit();
    }
    public void createLoginSession(String userAcc,String userPass){
        editor.putBoolean(KEY_IS_LOGIN,true);
        editor.putString(KEY_USER_ACC,userAcc);
        editor.putString(KEY_USER_PASS,userPass);
        editor.commit();
    }

    public HashMap<String, String> getUserDetailFromSession(){
        HashMap<String, String> userData = new HashMap<String, String>();
        userData.put(KEY_USER_ACC,userSession.getString(KEY_USER_ACC,null));
        userData.put(KEY_USER_PASS,userSession.getString(KEY_USER_PASS,null));
        return userData;
    }
    public boolean checkLogin(){
        if(userSession.getBoolean(KEY_IS_LOGIN,true)){
            return true;
        }else {
            return false;
        }
    }
    public void logOut(){
        editor.clear();
        editor.commit();
    }
}
