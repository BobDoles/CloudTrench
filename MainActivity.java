package com.mycompany.myapp;

import android.app.*;
import android.os.*;
import android.view.*;
import android.widget.*;

public class MainActivity extends Activity
{
	int counter;
	Button start;
	TextView display;
    /** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState)
	{
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
		start = (Button) findViewById(R.id.bStart);
		display = (TextView) findViewById(R.id.display);
		start.setOnClickListener(new View.OnClickListener() {
				public void onClick(View v){
					
					display.setText("Clicked button"); 
				}
			});
    }
}
