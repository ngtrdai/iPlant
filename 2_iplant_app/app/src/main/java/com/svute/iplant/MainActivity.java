package com.svute.iplant;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;
import androidx.appcompat.widget.PopupMenu;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import android.app.Notification;
import android.app.NotificationChannel;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.squareup.picasso.Picasso;
import com.svute.iplant.add.AddIplantFragment;
import com.svute.iplant.alarm.AlarmFragment;
import com.svute.iplant.control.ControlFragment;
import com.svute.iplant.home.HomeFragment;
import com.svute.iplant.home.IplantDetailFragment;
import com.svute.iplant.home.IplantListData;
import com.svute.iplant.home.IplantModel;
import com.svute.iplant.notification.NotificationFragment;

import de.hdodenhof.circleimageview.CircleImageView;

public class MainActivity extends AppCompatActivity implements PopupMenu.OnMenuItemClickListener {

    BottomNavigationView naviBottom;
    CircleImageView imageView;
    TextView txtLabel;
    FloatingActionButton floatingActionButton;
    private String labelPage ="";
    private UserIplant userIplant;
    private String keyGetPutData = "userIplant";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);
        setContentView(R.layout.activity_main);
        getUserIplant();
        addControls();
        addEvents();
        setImage();
        OpenFragmentHome();

    }

    private void OpenFragmentHome() {
        HomeFragment homeFragment = new HomeFragment();
        Bundle bundleHome = new Bundle();
        bundleHome.putParcelable(keyGetPutData, userIplant);
        homeFragment.setArguments(bundleHome);
        replaceFragment(homeFragment);
    }


    private void getUserIplant() {
        Intent intent = getIntent();
        if(intent != null){
            userIplant = (UserIplant) intent.getParcelableExtra(keyGetPutData);
            Log.d("User", userIplant.getNumIplant() +"");
        }
    }

    private void setImage() {
        Picasso.get()
                .load(userIplant.getUserImage().replaceFirst("format=svg","format=png&size=512&rounded=true"))
                .into(imageView);
    }

    private void addControls() {
        naviBottom = findViewById(R.id.navigationBottom);
        imageView = findViewById(R.id.imageAvatar);
        txtLabel = findViewById(R.id.txtLabel);
        floatingActionButton = (FloatingActionButton) findViewById(R.id.navigationAdd);

        naviBottom.setBackground(null);
        naviBottom.getMenu().getItem(2).setEnabled(false);
    }
    private void showPopup(View view){
        PopupMenu popupMenu = new PopupMenu(this, view);
        popupMenu.setOnMenuItemClickListener(this);
        popupMenu.inflate(R.menu.navigation_left);
        popupMenu.show();
    }

    private void addEvents() {
        imageView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                showPopup(view);
            }
        });
        naviBottom.setOnNavigationItemSelectedListener(new BottomNavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                int id = item.getItemId();
                Bundle bundle= new Bundle();
                bundle.putParcelable(keyGetPutData, userIplant);
                switch (id){
                    case R.id.navigationBottomHome:
                        labelPage = "Trang Chủ";
                        OpenFragmentHome();
                        break;
                    case R.id.navigationBottomControl:
                        labelPage = "Cài đặt tưới";
                        replaceFragment(new ControlFragment());
                        break;
                    case R.id.navigationBottomAlarm:
                        labelPage = "Thời gian tưới";
                        AlarmFragment alarmFragment = new AlarmFragment();
                        alarmFragment.setArguments(bundle);
                        replaceFragment(alarmFragment);
                        break;
                    case R.id.navigationBottomNoti:
                        labelPage = "Thông báo";
                        NotificationFragment notificationFragment = new NotificationFragment();
                        notificationFragment.setArguments(bundle);
                        replaceFragment(notificationFragment);
                        break;
                }
                txtLabel.setText(labelPage);
                return true;
            }
        });

        floatingActionButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                labelPage = "Thêm Chậu";
                txtLabel.setText(labelPage);

                AddIplantFragment addIplantFragment = new AddIplantFragment();
                Bundle bundle = new Bundle();
                bundle.putParcelable(keyGetPutData, userIplant);
                addIplantFragment.setArguments(bundle);
                replaceFragment(addIplantFragment);
            }
        });
    }

    private void replaceFragment(Fragment fragment){
        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();
        fragmentTransaction.replace(R.id.frameLayout,fragment);
        fragmentTransaction.commit();
    }

    @Override
    public boolean onMenuItemClick(MenuItem item) {
        int id = item.getItemId();
        switch (id){
            case R.id.menuInf:
                Intent intent = new Intent(MainActivity.this, InforAccActivity.class);
                intent.putExtra(keyGetPutData,userIplant);
                startActivity(intent);
                break;
            case R.id.menuLogOut:
                IplantListData.responeIplant.clear();
                IplantListData.iplantList.clear();
                IplantListData.iplantNameList.clear();
                IplantListData.iplantImgList.clear();
                SessionManager sessionManager = new SessionManager(getApplicationContext());
                sessionManager.logOut();
                Intent intent1 = new Intent(MainActivity.this, SignIn.class);
                startActivity(intent1);
                finish();
                break;
        }
        return true;
    }

    public void openIplantDetailFragment(IplantModel iplantModel){
        FragmentManager fragmentManager = getSupportFragmentManager();
        FragmentTransaction fragmentTransaction = fragmentManager.beginTransaction();
        IplantDetailFragment iplantDetailFragment = new IplantDetailFragment();
        Bundle bundle = new Bundle();
        bundle.putSerializable("objectIplant", iplantModel);
        bundle.putParcelable(keyGetPutData, userIplant);
        iplantDetailFragment.setArguments(bundle);
        fragmentTransaction.replace(R.id.frameLayout,iplantDetailFragment);
        fragmentTransaction.addToBackStack(IplantDetailFragment.TAG);
        fragmentTransaction.commit();
    }

}