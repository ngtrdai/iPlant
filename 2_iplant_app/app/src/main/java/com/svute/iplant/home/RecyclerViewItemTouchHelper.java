package com.svute.iplant.home;

import android.graphics.Canvas;
import android.view.View;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.recyclerview.widget.ItemTouchHelper;
import androidx.recyclerview.widget.RecyclerView;

import com.svute.iplant.home.IplantAdapter;
import com.svute.iplant.home.ItemTouchHelperListener;

public class RecyclerViewItemTouchHelper extends ItemTouchHelper.SimpleCallback {

    private com.svute.iplant.home.ItemTouchHelperListener listener;

    public RecyclerViewItemTouchHelper(int dragDirs, int swipeDirs, ItemTouchHelperListener listener) {
        super(dragDirs, swipeDirs);
        this.listener = listener;
    }

    @Override
    public boolean onMove(@NonNull RecyclerView recyclerView, @NonNull RecyclerView.ViewHolder viewHolder, @NonNull RecyclerView.ViewHolder target) {
        return true;
    }

    @Override
    public void onSwiped(@NonNull RecyclerView.ViewHolder viewHolder, int direction) {
        if(listener != null){
            listener.onSwiped(viewHolder);
        }
    }

    @Override
    public void onSelectedChanged(@Nullable RecyclerView.ViewHolder viewHolder, int actionState) {
        if(viewHolder != null ){
            try{
                View foreGroundView = ((IplantAdapter.iplantViewHolder) viewHolder).cardView;
                getDefaultUIUtil().onSelected(foreGroundView);
            }catch (Exception e){

            }

        }
    }

    @Override
    public void onChildDraw(@NonNull Canvas c, @NonNull RecyclerView recyclerView, @NonNull RecyclerView.ViewHolder viewHolder, float dX, float dY, int actionState, boolean isCurrentlyActive) {
        try {
            View foreGroundView = ((IplantAdapter.iplantViewHolder) viewHolder).cardView;
            getDefaultUIUtil().onDraw(c, recyclerView, foreGroundView, dX, dY, actionState, isCurrentlyActive);
        }catch (Exception e){

        }
    }

    @Override
    public void onChildDrawOver(@NonNull Canvas c, @NonNull RecyclerView recyclerView, RecyclerView.ViewHolder viewHolder, float dX, float dY, int actionState, boolean isCurrentlyActive) {
        try {
            View foreGroundView = ((IplantAdapter.iplantViewHolder) viewHolder).cardView;
            getDefaultUIUtil().onDrawOver(c,recyclerView,foreGroundView,dX,dY,actionState,isCurrentlyActive);
        }catch (Exception e){

        }

    }

    @Override
    public void clearView(@NonNull RecyclerView recyclerView, @NonNull RecyclerView.ViewHolder viewHolder) {

        try {
            View foreGroundView = ((IplantAdapter.iplantViewHolder) viewHolder).cardView;
            getDefaultUIUtil().clearView(foreGroundView);
        }catch (Exception e){

        }
    }
}
