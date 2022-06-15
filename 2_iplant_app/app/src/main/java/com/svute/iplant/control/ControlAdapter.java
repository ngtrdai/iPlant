package com.svute.iplant.control;

import android.app.Dialog;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.util.Log;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.ImageView;
import android.widget.NumberPicker;
import android.widget.Switch;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.svute.iplant.R;

import java.util.Arrays;
import java.util.List;

public class ControlAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder>{
    private List<ControlModel> controlModelsList;
    private final String urlToggleControl = "https://iplant.svute.com/api/controls/auto.php?act=toggle&imei=";
    private final String urlEditControl = "https://iplant.svute.com/api/controls/auto.php?act=edit&imei=";

    private int CONTROL_ITEM = 0;
    private int EMPTY_ITEM = 1;

    @Override
    public int getItemViewType(int position) {
        if(controlModelsList.get(position) == null){
            return EMPTY_ITEM;
        }
        return CONTROL_ITEM;
    }

    public void setControlAdapter(List<ControlModel> controlModelsList){
        this.controlModelsList = controlModelsList;
        notifyDataSetChanged();
    }
    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view =null;
        if(viewType == CONTROL_ITEM){
            view = layoutInflater.inflate(R.layout.cardview_control,parent,false);
            return new controlViewHolder(view);
        }else {
            view = layoutInflater.inflate(R.layout.cardview_null_iplant,parent,false);
            return new emptyViewHolder(view);
        }

    }

    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder holder, int position) {
        if(holder instanceof ControlAdapter.controlViewHolder){
            ControlModel controlModel = controlModelsList.get(position);
            ((ControlAdapter.controlViewHolder) holder).bind(controlModel);
        }
    }

    @Override
    public int getItemCount() {
        if(controlModelsList == null || controlModelsList.size() == 0){
            return 0;
        }
        return controlModelsList.size();
    }
    class emptyViewHolder extends RecyclerView.ViewHolder {
        public emptyViewHolder(@NonNull View itemView) {
            super(itemView);
        }
    }

    class controlViewHolder extends RecyclerView.ViewHolder {
        ImageView imageView;
        TextView txtSoild, txtTemp, txtLight, txtNameIplant;
        Switch mSwitchState;
        public controlViewHolder(@NonNull View itemView) {
            super(itemView);
            imageView = itemView.findViewById(R.id.imageControl);
            txtSoild = itemView.findViewById(R.id.textViewSoildControl);
            txtLight = itemView.findViewById(R.id.textViewLightControl);
            txtTemp = itemView.findViewById(R.id.textViewTempControl);
            mSwitchState = itemView.findViewById(R.id.switchStateControlIplant);
            txtNameIplant = itemView.findViewById(R.id.textViewNameIplantControll);
        }

        public void bind(ControlModel controlModel){
            txtNameIplant.setText(controlModel.getNameIplant());
            switch (controlModel.getmImgage()){
                case "img_iplant_1":
                    imageView.setImageResource(R.drawable.img_iplant_1);
                    break;
                case "img_iplant_2":
                    imageView.setImageResource(R.drawable.img_iplant_2);
                    break;
                case "img_iplant_3":
                    imageView.setImageResource(R.drawable.img_iplant_3);
                    break;
                case "img_iplant_4":
                    imageView.setImageResource(R.drawable.img_iplant_4);
                    break;
                case "img_iplant_5":
                    imageView.setImageResource(R.drawable.img_iplant_5);
                    break;
            }
            txtSoild.setText(controlModel.getmSensorSoil()+" %");
            txtLight.setText(controlModel.getmSensorLight()+" Lux");
            txtTemp.setText(controlModel.getmSensorTemp()+" °C");
            Log.d("TAG_toggle", "bind: "+controlModel.getImei()+" "+controlModel.getmTougle());
            Log.d("TAG_toggle", "bind: "+mSwitchState.isChecked());

            if(controlModel.getmTougle() == 0){
                mSwitchState.setChecked(false);
            }else {
                mSwitchState.setChecked(true);
            }
            mSwitchState.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
                    if(mSwitchState.isChecked()){
                        sendToggleControl(controlModel,"true");
                    }else {
                        sendToggleControl(controlModel,"1");
                    }

                }
            });
            itemView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    openDialogEdit(controlModel);
                }
            });

        }

        private void openDialogEdit(ControlModel controlModel) {
            final Dialog dialog = new Dialog(controlModel.getContextControl());
            dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
            dialog.setContentView(R.layout.dialog_edit_control);

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

            TextView txtNameIplant = dialog.findViewById(R.id.editTextDialogControlChangeName);
            NumberPicker numberPickerSoild = dialog.findViewById(R.id.numberPickerDialogControlSoild);
            NumberPicker numberPickerLight = dialog.findViewById(R.id.numberPickerDialogControlLight);
            NumberPicker numberPickerTemp = dialog.findViewById(R.id.numberPickerDialogControlTemp);
            Button btnOk = dialog.findViewById(R.id.buttonOkDialogControl);
            Button btnCancle = dialog.findViewById(R.id.buttonCancleDialogControl);

            txtNameIplant.setText(controlModel.getNameIplant());
            String[] tempValues = new String[81];
            double num = -0.5;
            for (int i = 0; i < tempValues.length; i++) {
                num+=0.5;
                tempValues[i] = num+"";
            }

            String[] soildValues = new String[201];
            double numSoild = -0.5;
            for (int i = 0; i < soildValues.length; i++) {
                numSoild+=0.5;
                soildValues[i] = numSoild+"";
            }

            numberPickerLight.setMaxValue(100);
            numberPickerLight.setMinValue(0);
            numberPickerLight.setValue(controlModel.getmSensorLight());

            numberPickerSoild.setMaxValue(200);
            numberPickerSoild.setMinValue(0);
            numberPickerSoild.setDisplayedValues(soildValues);
            numberPickerSoild.setValue(Arrays.asList(soildValues).indexOf(controlModel.getmSensorSoil()));

            numberPickerTemp.setMaxValue(80);
            numberPickerTemp.setMinValue(0);
            numberPickerTemp.setDisplayedValues(tempValues);
            numberPickerTemp.setValue(Arrays.asList(tempValues).indexOf(controlModel.getmSensorTemp()));

            btnOk.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    sendEditDataBase(controlModel, Double.parseDouble(soildValues[numberPickerSoild.getValue()]),numberPickerLight.getValue(),Double.parseDouble(tempValues[numberPickerTemp.getValue()]) );
                    dialog.dismiss();
                }
            });
            btnCancle.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    dialog.dismiss();
                }
            });
            dialog.show();
        }

        private void sendEditDataBase(ControlModel controlModel, double numberPickerSoild, int numberPickerLightValue, double numberPickerTempValue) {
            StringRequest request = new StringRequest(Request.Method.POST, urlEditControl+controlModel.getImei()+"&soil_moisture="+numberPickerSoild+"&temperature_env="+numberPickerTempValue+"&light_sensor="+numberPickerLightValue,new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("TUG", response);

                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                }
            });
            RequestQueue queue = Volley.newRequestQueue(controlModel.getContextControl());
            queue.add(request);
        }

        private void sendToggleControl(ControlModel controlModel, String mToggle) {
            StringRequest request = new StringRequest(Request.Method.POST, urlToggleControl+controlModel.getImei()+"&turnOn="+mToggle, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("TUG", response);
                    Log.d("TUG", urlToggleControl+controlModel.getImei()+"&turnOn="+mToggle);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                }
            });
            RequestQueue queue = Volley.newRequestQueue(controlModel.getContextControl());
            queue.add(request);
        }
    }
}
