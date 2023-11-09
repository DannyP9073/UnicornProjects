package za.co.ogma.danieldossantos.urbangrow;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
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

import za.co.ogma.danieldossantos.urbangrow.DB.UrbanGrowTable;

public class MyCropsActivity extends AppCompatActivity {

    Cursor cursor;
    private ListView listView;
    private Context context;
    private ImageButton btnAddNew;

    int intListViewItemPosition;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_crops);

        final UrbanGrowTable urbanGrowTable = new UrbanGrowTable(getBaseContext());

        listView = findViewById(R.id.listCropView);
        btnAddNew = findViewById(R.id.btnAddNew);

        urbanGrowTable.openDB();

        cursor = urbanGrowTable.getAllCrops();

        final CurrentCropAdapter cropAdapter = new CurrentCropAdapter();
        listView.setAdapter(cropAdapter);

        urbanGrowTable.closeDB();

        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {

                intListViewItemPosition = i;

                cursor.moveToPosition(intListViewItemPosition);

                String strID = cursor.getString(0);
                String strName = cursor.getString(1);
                String strPlant = cursor.getString(2);
                String strSeeds = cursor.getString(3);
                String strDate = cursor.getString(4);

                Intent intent = new Intent(MyCropsActivity.this, ViewCropActivity.class);
                intent.putExtra("ID", strID);
                intent.putExtra("Name", strName);
                intent.putExtra("Plant", strPlant);
                intent.putExtra("Seeds", strSeeds);
                intent.putExtra("Date", strDate);
                startActivity(intent);
            }
        });

        btnAddNew.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                startActivity(new Intent(MyCropsActivity.this, NewCropActivity.class));
            }
        });
    }

    class CurrentCropAdapter extends BaseAdapter {
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
                view = getLayoutInflater().inflate(R.layout.crop_list_view, viewGroup, false);

                holder.txtName = view.findViewById(R.id.txtName);
                holder.txtPlant = view.findViewById(R.id.txtID);
                holder.txtDate = view.findViewById(R.id.txtDate);

                view.setTag(holder);
            } else {
                holder = (ViewHolder)view.getTag();
            }

            cursor.moveToPosition(i);
            holder.txtName.setText(cursor.getString(1));
            holder.txtPlant.setText(cursor.getString(2));
            holder.txtDate.setText(cursor.getString(4));

            return view;
        }

        private class ViewHolder {
            TextView txtName;
            TextView txtPlant;
            TextView txtDate;
        }
    }
}
