package za.co.ogma.danieldossantos.urbangrow;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import za.co.ogma.danieldossantos.urbangrow.DB.UrbanGrowTable;

public class ViewCropActivity extends AppCompatActivity {

    private TextView txtName;
    private EditText edtPlant;
    private EditText edtSeeds;
    private EditText edtDate;
    private ImageButton btnSave;
    private ImageButton btnEdit;
    private ImageButton btnUpdate;
    private ImageButton btnDelete;
    private ImageView cropImage;

    public String strID2;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_crop);

        final String strID = getIntent().getStringExtra("ID");
        final String strName = getIntent().getStringExtra("Name");
        final String strPlant = getIntent().getStringExtra("Plant");
        final String strSeeds = getIntent().getStringExtra("Seeds");
        final String strDate = getIntent().getStringExtra("Date");

        txtName = findViewById(R.id.txtName);
        edtPlant = findViewById(R.id.edtPlant);
        edtSeeds = findViewById(R.id.edtNoSeeds);
        edtDate = findViewById(R.id.edtDate);
        btnSave = findViewById(R.id.btnSave);
        btnEdit = findViewById(R.id.btnEdit);
        btnUpdate = findViewById(R.id.btnUpdate);
        btnDelete = findViewById(R.id.btnDelete);

        txtName.setText(strName);
        edtPlant.setText(strPlant);
        edtSeeds.setText(strSeeds);
        edtDate.setText(strDate);
        edtPlant.setEnabled(false);
        edtSeeds.setEnabled(false);
        edtDate.setEnabled(false);

        strID2 = strID;

        btnSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String stID = strID;
                String stName = txtName.getText().toString();
                String stPlant = edtPlant.getText().toString();
                String stSeeds = edtSeeds.getText().toString();
                String stDate = edtDate.getText().toString();

                UrbanGrowTable urbanGrowTable = new UrbanGrowTable(getBaseContext());

                if (edtPlant.isEnabled()){
                    urbanGrowTable.openDB();
                    urbanGrowTable.updateCropLabel(stID, stName, stPlant, stSeeds, stDate);
                    Toast.makeText(getBaseContext(), "Crop card saved successfully!", Toast.LENGTH_LONG).show();
                    urbanGrowTable.closeDB();
                    edtPlant.setEnabled(false);
                    edtSeeds.setEnabled(false);
                    edtDate.setEnabled(false);
                } else {
                    Toast.makeText(getBaseContext(), "You have not edited anything!", Toast.LENGTH_LONG).show();
                }
            }
        });

        btnEdit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                edtPlant.setEnabled(true);
                edtSeeds.setEnabled(true);
                edtDate.setEnabled(true);
            }
        });

        btnDelete.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                AlertDialog.Builder dialog = new AlertDialog.Builder(ViewCropActivity.this);
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

        btnUpdate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(ViewCropActivity.this, ViewCropEntriesActivity.class);
                intent.putExtra("Name", strName);
                intent.putExtra("ID", strID);
                startActivity(intent);
            }
        });
    }

    @Override
    protected void onResume() {
        super.onResume();
        final String strName = getIntent().getStringExtra("Name");
        final String strPlant = getIntent().getStringExtra("Plant");
        final String strSeeds = getIntent().getStringExtra("Seeds");
        final String strDate = getIntent().getStringExtra("Date");

        txtName.setText(strName);
        edtPlant.setText(strPlant);
        edtSeeds.setText(strSeeds);
        edtDate.setText(strDate);

    }

    public void deleteCrop(){
        String stID = strID2;
        String stName = txtName.getText().toString();
        String stPlant = edtPlant.getText().toString();
        String stSeeds = edtSeeds.getText().toString();
        String stDate = edtDate.getText().toString();

        UrbanGrowTable urbanGrowTable = new UrbanGrowTable(getBaseContext());
        urbanGrowTable.openDB();
        urbanGrowTable.deleteRecord(stID, stName, stPlant,stSeeds, stDate);
        Toast.makeText(getBaseContext(), "Crop successfully removed.", Toast.LENGTH_LONG).show();
        urbanGrowTable.closeDB();
        startActivity(new Intent(ViewCropActivity.this, MyCropsActivity.class));
    }
}
