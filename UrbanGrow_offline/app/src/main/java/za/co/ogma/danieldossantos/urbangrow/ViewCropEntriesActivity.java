package za.co.ogma.danieldossantos.urbangrow;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.TextView;

import java.util.List;

import za.co.ogma.danieldossantos.urbangrow.DB.UrbanGrowTable;

public class ViewCropEntriesActivity extends AppCompatActivity {

    Cursor cursor;
    private ListView listView;
    int intListViewItemPosition;
    private ImageButton btnAddNew;
    private TextView txtName;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_view_crop_entries);

        String strName = getIntent().getStringExtra("Name");
        final String strID = getIntent().getStringExtra("ID");

        final UrbanGrowTable urbanGrowTable = new UrbanGrowTable(getBaseContext());

        listView = findViewById(R.id.listCropEntries);
        btnAddNew = findViewById(R.id.btnAddNew);
        txtName = findViewById(R.id.txtCropName);

        txtName.setText(strName);

        urbanGrowTable.openDB();

        cursor = urbanGrowTable.getCropUpdateRecords(strID);

        final CropEntryAdapter cropEntryAdapter = new CropEntryAdapter();
        listView.setAdapter(cropEntryAdapter);

        urbanGrowTable.closeDB();

        btnAddNew.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(ViewCropEntriesActivity.this, AddNewCropEntryActivity.class);
                intent.putExtra("ID", strID);
                startActivity(intent);
            }
        });

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                intListViewItemPosition = i;

                cursor.moveToPosition(intListViewItemPosition);

                String stID = cursor.getString(0);
                String stTemp = cursor.getString(1);
                String stHum = cursor.getString(2);
                String stLight = cursor.getString(3);
                String stDate = cursor.getString(4);
                String stPrune = cursor.getString(5);
                String stWater = cursor.getString(6);
                String stNutri = cursor.getString(7);
                String stPH = cursor.getString(8);
                String stFert = cursor.getString(9);
                String stStage = cursor.getString(10);
                String stNotes = cursor.getString(11);

                Intent intent = new Intent(ViewCropEntriesActivity.this, ViewEntryActivity.class);
                intent.putExtra("ID", stID);
                intent.putExtra("Temp", stTemp);
                intent.putExtra("Hum", stHum);
                intent.putExtra("Light", stLight);
                intent.putExtra("Date", stDate);
                intent.putExtra("Prune", stPrune);
                intent.putExtra("Water", stWater);
                intent.putExtra("Nutri", stNutri);
                intent.putExtra("PH", stPH);
                intent.putExtra("Fert", stFert);
                intent.putExtra("Stage", stStage);
                intent.putExtra("Notes", stNotes);
                startActivity(intent);
            }
        });
    }

    class CropEntryAdapter extends BaseAdapter{

        @Override
        public int getCount() {
            return cursor.getCount();
        }

        @Override
        public Object getItem(int i) {
            return null;
        }

        @Override
        public long getItemId(int i) {
            return 0;
        }

        @Override
        public View getView(int i, View view, ViewGroup viewGroup) {
            ViewHolder holder;
            if (view == null){
                holder = new ViewHolder();
                view = getLayoutInflater().inflate(R.layout.crop_data_entries, viewGroup,false);

                holder.txtDate = view.findViewById(R.id.txtDate);
                holder.txtStage = view.findViewById(R.id.txtStage);

                view.setTag(holder);
            }else {
                holder = (ViewHolder)view.getTag();
            }

            cursor.moveToPosition(i);
            holder.txtDate.setText(cursor.getString(4));
            holder.txtStage.setText(cursor.getString(10));

            return view;
        }
    }

    private class ViewHolder {
        TextView txtDate;
        TextView txtStage;
    }
}