package com.svute.iplant.alarm;

import android.graphics.Color;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CompoundButton;
import android.widget.ImageView;
import android.widget.Switch;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.cardview.widget.CardView;
import androidx.recyclerview.widget.RecyclerView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.svute.iplant.R;

import java.util.List;

public class AlarmAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder>{

    private List<AlarmModel> alarmModelList;
    private final String urlToggleAlarm = "https://iplant.svute.com/api/controls/alarm.php?act=toggleLoop&id=";

    private int ALARM_ITEM = 0;
    private int EMPTY_ITEM = 1;

    @Override
    public int getItemViewType(int position) {
        if(alarmModelList.get(position) == null){
            return EMPTY_ITEM;
        }
        return ALARM_ITEM;
    }
    public AlarmAdapter(){}
    public void setDataAlarmAdapter(List<AlarmModel> alarmModelList){
        this.alarmModelList = alarmModelList;
        notifyDataSetChanged();
    }

    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater =LayoutInflater.from(parent.getContext());
        View view = null;
        if(viewType == ALARM_ITEM){
            view = layoutInflater.inflate(R.layout.cardview_time,parent,false);
            return new AlarmViewHolder(view);
        }else{
            view = layoutInflater.inflate(R.layout.cardview_null_iplant,parent,false);
            return new emptyViewHolder(view);
        }

    }

    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder holder, int position) {
        if(holder instanceof AlarmViewHolder){
            AlarmModel alarmModel    = alarmModelList.get(position);
            ((AlarmViewHolder) holder).binhd(alarmModel);
        }
    }

    @Override
    public int getItemCount() {
        if(alarmModelList == null || alarmModelList.size() == 0){
            return 0;
        }
        return alarmModelList.size();
    }
    class emptyViewHolder extends RecyclerView.ViewHolder{

        public emptyViewHolder(@NonNull View itemView) {
            super(itemView);
        }
    }
    class AlarmViewHolder extends RecyclerView.ViewHolder {
        TextView txtLineClor, txtNameIplant, txtHourMinute, txtDay;
        CardView cardView;
        Switch swOnOff;
        ImageView imageView, imgWater, imgUv;
        public AlarmViewHolder(@NonNull View itemView) {
            super(itemView);
            txtLineClor = itemView.findViewById(R.id.textViewColorControl);
            txtNameIplant = itemView.findViewById(R.id.textViewNameIplantControl);
            txtHourMinute = itemView.findViewById(R.id.textViewTimeControl);
            txtDay = itemView.findViewById(R.id.textViewDateTime);
            swOnOff = itemView.findViewById(R.id.switch1);
            imageView = itemView.findViewById(R.id.imageControl);
            cardView = itemView.findViewById(R.id.cardViewAddAlarm);
            imgWater = itemView.findViewById(R.id.imageViewWaterAlarm);
            imgUv = itemView.findViewById(R.id.imageViewSunAlarm);
        }
        private void binhd(AlarmModel alarmModel){
            txtLineClor.setBackgroundColor(Color.rgb(alarmModel.getLineRed(),alarmModel.getLineGreen(),alarmModel.getLineBlue()));
            txtNameIplant.setText(alarmModel.getIplantName());
            txtHourMinute.setText(alarmModel.getmHour()+":"+alarmModel.getmMinute());
            txtDay.setText(alarmModel.getmDayMoth());
            switch (alarmModel.getIplantImage()){
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
            switch (alarmModel.getSwWater()){
                case 1:
                    imgWater.setImageResource(R.drawable.ic_water_fill);
                    break;
                case 0:
                    imgWater.setImageResource(R.drawable.ic_water_black);
                    break;
            }
            switch (alarmModel.getSwUv()){
                case 0:
                    imgUv.setImageResource(R.drawable.ic_sun_empty);
                    break;
                case 1:
                    imgUv.setImageResource(R.drawable.ic_sun_fill);
                    break;
            }switch (alarmModel.getSwAuto()){
                case 0:
                    swOnOff.setChecked(false);
                    break;
                case 1:
                    swOnOff.setChecked(true);
                    break;
            }
            swOnOff.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
                @Override
                public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
                    if(swOnOff.isChecked()){
                        sendToggleControl(alarmModel,"on");
                    }else {
                        sendToggleControl(alarmModel,"1");
                    }
                }
            });
        }

        private void sendToggleControl(AlarmModel alarmModel, String aTrue) {
            StringRequest request = new StringRequest(Request.Method.POST, urlToggleAlarm+alarmModel.getId()+"&flag_loop="+aTrue, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    Log.d("TUG", response);
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                }
            });
            RequestQueue queue = Volley.newRequestQueue(alarmModel.getContextAlarm());
            queue.add(request);
        }
    }
    public void removeAlarm(int index){
        alarmModelList.remove(index);
        notifyItemRemoved(index);
    }

    public void undoAlarm(AlarmModel alarmModel,int index){
        alarmModelList.add(index, alarmModel);
        notifyItemInserted(index);
    }
}
