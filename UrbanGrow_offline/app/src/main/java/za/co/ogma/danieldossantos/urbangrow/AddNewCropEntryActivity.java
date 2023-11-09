package za.co.ogma.danieldossantos.urbangrow;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Toast;

import za.co.ogma.danieldossantos.urbangrow.DB.UrbanGrowTable;

public class AddNewCropEntryActivity extends AppCompatActivity {

    private EditText edtTemp;
    private EditText edtHum;
    private EditText edtWater;
    private EditText edtLight;
    private EditText edtDate;
    private EditText edtNutrient;
    private EditText edtPH;
    private EditText edtFert;
    private EditText edtNotes;

    private RadioButton rdPrune;
    private RadioButton rdStage;


    private RadioGroup rdgPrune;
    private RadioGroup rdgStage;

    private ImageButton btnSave;
    private ImageButton btnDelete;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_new_crop_entry);

        final String strID = getIntent().getStringExtra("ID");

        edtTemp = findViewById(R.id.edtTemp);
        edtHum = findViewById(R.id.edtHum);
        edtWater = findViewById(R.id.edtWater);
        edtLight = findViewById(R.id.edtLight);
        edtDate = findViewById(R.id.edtDate);
        edtNutrient = findViewById(R.id.edtNutrient);
        edtPH = findViewById(R.id.edtPH);
        edtFert = findViewById(R.id.edtFertiliser);
        edtNotes = findViewById(R.id.edtNotes);

        rdgPrune = findViewById(R.id.rdgPrune);
        rdgStage = findViewById(R.id.rdgStage);

        btnSave = findViewById(R.id.btnSave);
        btnDelete = findViewById(R.id.btnDelete);

        btnSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                int selectedPrune = rdgPrune.getCheckedRadioButtonId();
                int selectedStage = rdgStage.getCheckedRadioButtonId();

                rdPrune = findViewById(selectedPrune);
                rdStage = findViewById(selectedStage);

                String strTemp = edtTemp.getText().toString();
                String strHum = edtHum.getText().toString();
                String strLight = edtLight.getText().toString();
                String strDate = edtDate.getText().toString();
                String strPrune = rdPrune.getText().toString();
                String strStage = rdStage.getText().toString();
                String strWater = edtWater.getText().toString();
                String strNutri = edtNutrient.getText().toString();
                String strPH = edtPH.getText().toString();
                String strFert = edtFert.getText().toString();
                String strNotes = edtNotes.getText().toString();

                if (strTemp.equals("") || strHum.equals("") || strLight.equals("") || strDate.equals("")){
                    Toast.makeText(AddNewCropEntryActivity.this, "Please fill in all the required fields!", Toast.LENGTH_LONG).show();
                } else{
                    UrbanGrowTable urbanGrowTable = new UrbanGrowTable(getBaseContext());

                    urbanGrowTable.openDB();
                    urbanGrowTable.insertCropUpdate(strID, strTemp, strHum, strLight, strDate, strPrune, strWater, strNutri, strPH, strFert, strNotes, strStage);
                    urbanGrowTable.closeDB();
                    Toast.makeText(AddNewCropEntryActivity.this, "Entry Saved!", Toast.LENGTH_LONG).show();

                    startActivity(new Intent(AddNewCropEntryActivity.this, MyCropsActivity.class));
                }
            }
        });
        btnDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Toast.makeText(AddNewCropEntryActivity.this, "Entry saved unsuccessfully!", Toast.LENGTH_LONG).show();
                startActivity(new Intent(AddNewCropEntryActivity.this, MyCropsActivity.class));
            }
        });
    }
}
