package com.svute.iplant;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import de.hdodenhof.circleimageview.CircleImageView;

public class InforAccActivity extends AppCompatActivity {

    CircleImageView imageView;
    ImageButton imageButton;
    TextView txtName, txtAcc,txtNumPlant;
    private String keyGetPutData = "userIplant";
    UserIplant userIplant;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_infor_acc);
        AppCompatDelegate.setDefaultNightMode(AppCompatDelegate.MODE_NIGHT_NO);


        Intent intent = getIntent();
        if(intent != null){
            userIplant= intent.getParcelableExtra(keyGetPutData);
        }

        imageView = findViewById(R.id.imageAvatarInfor);
        txtName = findViewById(R.id.txtFullName);
        txtAcc = findViewById(R.id.txtAcc);
        imageButton = findViewById(R.id.imgButton);
        txtNumPlant = findViewById(R.id.txtIplant);

        txtAcc.setText("@"+ userIplant.getUserAcc());
        txtName.setText(userIplant.getUserName());
        txtNumPlant.setText("iPlants - " + userIplant.getNumIplant());
        Picasso.get().load(userIplant.getUserImage().replaceFirst("format=svg","format=png&size=512&rounded=true")).into(imageView);
        imageButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(InforAccActivity.this, MainActivity.class);
                startActivity(intent);
                finish();
            }
        });
    }
}