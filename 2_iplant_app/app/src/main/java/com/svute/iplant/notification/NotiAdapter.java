package com.svute.iplant.notification;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.svute.iplant.R;
import com.svute.iplant.control.ControlModel;

import java.util.List;

public class NotiAdapter extends RecyclerView.Adapter<RecyclerView.ViewHolder> {
    private List<NotiModel> notiModelList;
    private int NOTI_ITEM = 0;
    private int EMPTY_ITEM = 1;

    public void setNotiAdapter(List<NotiModel> notiModelList){
        this.notiModelList = notiModelList;
        notifyDataSetChanged();
    }
    @Override
    public int getItemViewType(int position) {
        if(notiModelList.get(position) == null){
            return EMPTY_ITEM;
        }
        return NOTI_ITEM;
    }
    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        LayoutInflater layoutInflater =LayoutInflater.from(parent.getContext());
        View view = null;
        if (viewType == NOTI_ITEM){
            view = layoutInflater.inflate(R.layout.cardview_noti,parent,false);
            return new NotiViewHolder(view);
        }else {
            view = layoutInflater.inflate(R.layout.cardview_empty,parent,false);
            return new emptyViewHolder(view);
        }

    }

    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder holder, int position) {
        if(holder instanceof NotiAdapter.NotiViewHolder){
            NotiModel notiModel = notiModelList.get(position);
            ((NotiAdapter.NotiViewHolder) holder).bind(notiModel);
        }
    }

    @Override
    public int getItemCount() {
        if(notiModelList == null || notiModelList.size() == 0){
            return 0;
        }
        return notiModelList.size();
    }
    class emptyViewHolder extends RecyclerView.ViewHolder {
        public emptyViewHolder(@NonNull View itemView) {
            super(itemView);
        }
    }

    class NotiViewHolder extends RecyclerView.ViewHolder {
        ImageView img;
        TextView txtTitle, txtContent, txtTime;

        public NotiViewHolder(@NonNull View itemView) {
            super(itemView);
            img = itemView.findViewById(R.id.imageViewNoti);
            txtTitle = itemView.findViewById(R.id.textViewTitleNoti);
            txtContent = itemView.findViewById(R.id.textViewNotiContent);
            txtTime = itemView.findViewById(R.id.textViewNotiTime);
        }

        private void bind(NotiModel notiModel){
            switch (notiModel.getmImage()){
                case "img_iplant_1":
                    img.setImageResource(R.drawable.img_iplant_1);
                    break;
                case "img_iplant_2":
                    img.setImageResource(R.drawable.img_iplant_2);
                    break;
                case "img_iplant_3":
                    img.setImageResource(R.drawable.img_iplant_3);
                    break;
                case "img_iplant_4":
                    img.setImageResource(R.drawable.img_iplant_4);
                    break;
                case "img_iplant_5":
                    img.setImageResource(R.drawable.img_iplant_5);
                    break;
            }
            String[] xuLyTitle = notiModel.getmTitle().split("-");
            txtTitle.setText(xuLyTitle[0]+"\n"+xuLyTitle[1]);
            txtContent.setText(notiModel.getmContent());
            txtTime.setText(notiModel.getmTime());
        }

    }
}
