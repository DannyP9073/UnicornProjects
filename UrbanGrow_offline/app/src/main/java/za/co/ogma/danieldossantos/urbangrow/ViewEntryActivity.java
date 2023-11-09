package za.co.ogma.danieldossantos.urbangrow;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import za.co.ogma.danieldossantos.urbangrow.DB.UrbanGrowTable;

public class ViewEntryActivity extends AppCompatActivity {

    private TextView txtTemp;
    private TextView txtHum;
    private TextView txtLight;
    private TextView txtDate;
    private TextView txtPrune;
    private TextView txtWater;
    private TextView txtNutri;
    private TextView txtPH;
    private TextView txtFert;
    private TextView txtStage;
    private TextView txtNotes;

    private ImageButton btnDelete;
    private ImageButton btnReturn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_entry);

        String strID = getIntent().getStringExtra("ID");
        String strTemp = getIntent().getStringExtra("Temp");
        String strHum = getIntent().getStringExtra("Hum");
        String stright = getIntent().getStringExtra("Light");
        String strDate = getIntent().getStringExtra("Date");
        String strPrune = getIntent().getStringExtra("Prune");
        String strWater = getIntent().getStringExtra("Water");
        String strNutri= getIntent().getStringExtra("Nutri");
        String strPH = getIntent().getStringExtra("PH");
        String strFert = getIntent().getStringExtra("Fert");
        String strStage = getIntent().getStringExtra("Stage");
        String strNotes = getIntent().getStringExtra("Notes");

        txtTemp = findViewById(R.id.txtTemp);
        txtHum = findViewById(R.id.txtHum);
        txtLight = findViewById(R.id.txtLight);
        txtDate = findViewById(R.id.txtDate);
        txtPrune = findViewById(R.id.txtPrune);
        txtWater = findViewById(R.id.txtWater);
        txtNutri = findViewById(R.id.txtNutri);
        txtPH = findViewById(R.id.txtPH);
        txtFert = findViewById(R.id.txtFert);
        txtStage = findViewById(R.id.txtStage);
        txtNotes = findViewById(R.id.txtNotes);

        txtTemp.setText(strTemp);
        txtHum.setText(strHum);
        txtLight.setText(stright);
        txtDate.setText(strDate);
        txtPrune.setText(strPrune);
        txtWater.setText(strWater);
        txtNutri.setText(strNutri);
        txtPH.setText(strPH);
        txtFert.setText(strFert);
        txtStage.setText(strStage);
        txtNotes.setText(strNotes);

        btnDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                AlertDialog.Builder dialog = new AlertDialog.Builder(ViewEntryActivity.this);
                dialog.setCancelable(false);
                dialog.setTitle("Delete Crop!");
                dialog.setMessage("Are you sure you want to delete this crop?" );
                dialog.setPositiveButton("Delete", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int id) {
                        //Action for "Delete".
                        deleteCrop();
                    }
                })
                        .setNegativeButton("Cancel ", new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int which) {
                                //Action for "Cancel".
                                dialog.cancel();
                            }
                        });

                final AlertDialog alert = dialog.create();
                alert.show();
            }
        });
    }

    private void deleteCrop() {

        String strID = getIntent().getStringExtra("ID");
        String strTemp = txtTemp.getText().toString();
        String strHum = txtHum.getText().toString();
        String stright = txtLight.getText().toString();
        String strDate = txtDate.getText().toString();
        String strPrune = txtPrune.getText().toString();
        String strWater = txtWater.getText().toString();
        String strNutri= txtNutri.getText().toString();
        String strPH = txtPH.getText().toString();
        String strFert = txtFert.getText().toString();
        String strStage = txtStage.getText().toString();
        String strNotes = txtNotes.getText().toString();

        UrbanGrowTable urbanGrowTable = new UrbanGrowTable(getBaseContext());
        urbanGrowTable.openDB();
        urbanGrowTable.deleteEntry(strID, strTemp, strHum, stright, strDate, strPrune, strWater, strNutri, strPH, strFert, strStage,strNotes);
        Toast.makeText(getBaseContext(), "Crop successfully removed.", Toast.LENGTH_LONG).show();
        urbanGrowTable.closeDB();
        startActivity(new Intent(ViewEntryActivity.this, MyCropsActivity.class));
    }
}
