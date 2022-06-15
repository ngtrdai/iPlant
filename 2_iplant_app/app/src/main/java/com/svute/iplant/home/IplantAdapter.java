package com.svute.iplant.home;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.cardview.widget.CardView;
import androidx.recyclerview.widget.RecyclerView;

import com.svute.iplant.R;
import com.svute.iplant.alarm.AlarmModel;

import java.util.ArrayList;
import java.util.List;

public class IplantAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder> {
    private List<IplantModel> iplantModelList;
    private IClickItemListener mIClickItemListener;

    private int IPLANT_ITEM = 0;
    private int NULL_ITEM = 2;
    private int EMPTY_ITEM = 1;

    @Override
    public int getItemViewType(int position) {
        if(iplantModelList.get(position) == null){
            return EMPTY_ITEM;
        }else if(iplantModelList.get(position).getImeiIplant() == "Null") {
            return NULL_ITEM;
        }
        return IPLANT_ITEM;
    }

    public IplantAdapter(){}
    public void setIplantAdapter(List<IplantModel> iplantModelList,IClickItemListener mIClickItemListener){
        this.iplantModelList = iplantModelList;
        this.mIClickItemListener = mIClickItemListener;
        notifyDataSetChanged();
    }
    public void setIplantAdapter(List<IplantModel> iplantModelList){
        this.iplantModelList = iplantModelList;
        notifyDataSetChanged();
    }

    public interface IClickItemListener{
        void onClickItemIplant(IplantModel iplantModel);
    }
    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater = LayoutInflater.from(parent.getContext());
        View view = null;
        switch (viewType){
            case 0:
                view =layoutInflater.inflate(R.layout.cardview_iplant,parent,false);
                return new iplantViewHolder(view);
            case 1:
                view =layoutInflater.inflate(R.layout.cardview_empty,parent,false);
                return new emptyViewHolder(view);
            case 2:
                view =layoutInflater.inflate(R.layout.cardview_null_iplant,parent,false);
                return new nullValueViewHolder(view);
        }
        return null;
    }

    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder holder, int position) {
        if(holder instanceof iplantViewHolder){
            IplantModel iplantModel = iplantModelList.get(position);
            ((iplantViewHolder) holder).bind(iplantModel);
            ((iplantViewHolder) holder).cardView.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View view) {
                    mIClickItemListener.onClickItemIplant(iplantModel);
                }
            });
        }

    }

    @Override
    public int getItemCount() {
        if(iplantModelList == null|| iplantModelList.size() == 0){
            return 0;
        }
        return iplantModelList.size();
    }
    class nullValueViewHolder extends RecyclerView.ViewHolder {
        public nullValueViewHolder(@NonNull View itemView) {
            super(itemView);
        }
    }

    class emptyViewHolder extends RecyclerView.ViewHolder{

        public emptyViewHolder(@NonNull View itemView) {
            super(itemView);
        }
    }
    class iplantViewHolder extends RecyclerView.ViewHolder{
        TextView txtTemp, txtNameIplant;
        CardView cardView;
        ProgressBar pgBarSoil, pgBarLight, pgBarWater;
        ImageView imgIpant;
        public iplantViewHolder(@NonNull View itemView) {
            super(itemView);
            pgBarSoil = itemView.findViewById(R.id.progressBarSoil);
            pgBarLight = itemView.findViewById(R.id.progressBarlight);
            pgBarWater = itemView.findViewById(R.id.progressBarWater);
            txtTemp = itemView.findViewById(R.id.textViewValueTemp);
            txtNameIplant = itemView.findViewById(R.id.textViewNamePlant);
            cardView = itemView.findViewById(R.id.cardView);
            imgIpant = itemView.findViewById(R.id.imageViewIplantHome);

        }
        public void bind(IplantModel iplantModel){
            pgBarSoil.setProgress(Math.round(Float.parseFloat(iplantModel.getSensorSoil())));
            pgBarLight.setProgress(Math.round(Float.parseFloat(iplantModel.getSensorLight())));
            txtTemp.setText(iplantModel.getSensorTemp()+" °C");
            pgBarWater.setProgress(Integer.parseInt(iplantModel.getSensorWater()));
            txtNameIplant.setText(iplantModel.getNameIplant());
            switch (iplantModel.getImgIplant()){
                case "img_iplant_1":
                    imgIpant.setImageResource(R.drawable.img_iplant_1);
                    break;
                case "img_iplant_2":
                    imgIpant.setImageResource(R.drawable.img_iplant_2);
                    break;
                case "img_iplant_3":
                    imgIpant.setImageResource(R.drawable.img_iplant_3);
                    break;
                case "img_iplant_4":
                    imgIpant.setImageResource(R.drawable.img_iplant_4);
                    break;
                case "img_iplant_5":
                    imgIpant.setImageResource(R.drawable.img_iplant_5);
                    break;
            }
        }
    }
    public void removeIplant(int index){
        iplantModelList.remove(index);
        notifyItemRemoved(index);
    }

    public void undoIplant(IplantModel iplantModel, int index){
        iplantModelList.add(index, iplantModel);
        notifyItemInserted(index);
    }
}
