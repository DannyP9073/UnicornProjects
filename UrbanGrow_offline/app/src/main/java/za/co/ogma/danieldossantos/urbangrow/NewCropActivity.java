package za.co.ogma.danieldossantos.urbangrow;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import za.co.ogma.danieldossantos.urbangrow.DB.UrbanGrowTable;

public class NewCropActivity extends AppCompatActivity {

    private EditText edtName;
    private EditText edtPlant;
    private EditText edtNumSeeds;
    private EditText edtDate;

    private ImageButton btnSave;
    private ImageButton btnReturn;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_new_crop);

        edtName = findViewById(R.id.edtName);
        edtPlant = findViewById(R.id.edtPlant);
        edtNumSeeds = findViewById(R.id.edtNoSeeds);
        edtDate = findViewById(R.id.edtDate);
        btnSave = findViewById(R.id.btnSave);
        btnReturn = findViewById(R.id.btnDelete);

        btnSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                String strName = edtName.getText().toString();
                String strPlant = edtPlant.getText().toString();
                String strNumSeeds = edtNumSeeds.getText().toString();
                String strDate = edtDate.getText().toString();

                if (strName.equals("") || strPlant.equals("")|| strNumSeeds.equals("") || strDate.equals("")) {
                    Toast.makeText(NewCropActivity.this, "Fill in fields!", Toast.LENGTH_LONG).show();
                } else {
                    saveCrop();
                }
            }
        });

        btnReturn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                // set return onclick listener
                Toast.makeText(NewCropActivity.this, "New crop save unsuccessful!", Toast.LENGTH_LONG).show();
                startActivity(new Intent(NewCropActivity.this, MyCropsActivity.class));
            }
        });
    }
    /* Write the saveCrop method to save record to database */
    private void saveCrop() {
        String strName = edtName.getText().toString();
        String strPlant = edtPlant.getText().toString();
        String strNumSeeds = edtNumSeeds.getText().toString();
        String strDate = edtDate.getText().toString();

        UrbanGrowTable urbanGrowTable = new UrbanGrowTable(getBaseContext());

        urbanGrowTable.openDB();
        urbanGrowTable.insertCrop(strName, strPlant, strNumSeeds, strDate);
        urbanGrowTable.closeDB();

        edtName.setText("");
        edtPlant.setText("");
        edtNumSeeds.setText("");
        edtDate.setText("");

        Toast.makeText(NewCropActivity.this, "Successful!", Toast.LENGTH_LONG).show();
        startActivity(new Intent(NewCropActivity.this, MyCropsActivity.class));
    }

    /* Add to activity life cycle  resume, pause, stop and destroy */
}
