package com.svute.iplant.home;

import android.util.Log;

import com.github.mikephil.charting.components.AxisBase;
import com.github.mikephil.charting.data.Entry;
import com.github.mikephil.charting.formatter.IAxisValueFormatter;
import com.github.mikephil.charting.formatter.IValueFormatter;
import com.github.mikephil.charting.formatter.ValueFormatter;
import com.github.mikephil.charting.utils.ViewPortHandler;

import java.text.SimpleDateFormat;
import java.util.Date;

public class DateAxisValueFormatter extends ValueFormatter {


    @Override
    public String getAxisLabel(float value, AxisBase axis) {
        Log.d("TAG_XULY", "getAxisLabel: "+value/1000);
        int axisValue = (int) value/40;
        if (axisValue >= 0) {
            String sh = String.format("%02d:%02d", (axisValue / 3600 * 60 + ((axisValue % 3600) / 60)), (axisValue % 60));
            return sh;
        } else {
            return "";
        }
    }
}
