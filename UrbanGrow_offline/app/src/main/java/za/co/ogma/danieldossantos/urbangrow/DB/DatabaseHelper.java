package za.co.ogma.danieldossantos.urbangrow.DB;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

/* Add table file to the database */

public class DatabaseHelper extends SQLiteOpenHelper {

    private static final String DATABASE_NAME = "UrbanGrow";
    private static final int DATABASE_VERSION = 1;

    //Crop label
    static final String CROP_TABLE = "ugCrop";
    static final String CROP_ID = "cropID";
    static final String CROP_NAME = "cropName";
    static final String CROP_PLANT = "cropPlant";
    static final String CROP_SEEDS_TOTAL = "cropTotalSeeds";
    static final String CROP_DATE = "cropDate";

    //Crop Update
    static final String CROP_UPDATE_TABLE = "ugCropUpdater";
    static final String UPDATE_ID = "weatherID";
    static final String WEATHER_TEMP = "weatherTemp";
    static final String WEATHER_HUM = "weatherHum";
    static final String WEATHER_LIGHT = "weatherLight";
    static final String WEATHER_DATE = "weatherDate";
    static final String TREATMENT_PRUN = "treatmentPrun";
    static final String TREATMENT_WATER = "treatmentWater";
    static final String TREATMENT_NUTRI = "treatmentNutri";
    static final String TREATMENT_PH = "treatmentPH";
    static final String TREATMENT_FERT = "treatmentFert";
    static final String TREATMENT_STAGE = "treatmentStage";
    static final String TREATMENT_NOTES = "treatmentNotes";

    //Finish "create table" string
    private static final String  CREATE_TABLE = "CREATE TABLE " + " " + CROP_TABLE + "(" + CROP_ID + " " + "INTEGER PRIMARY KEY AUTOINCREMENT," + CROP_NAME + " " + "TEXT," + CROP_PLANT + " " + "TEXT," + CROP_SEEDS_TOTAL +" " + "TEXT," + CROP_DATE + " " + "TEXT)";

    private static final String  CREATE_TABLE2 = "CREATE TABLE " + " " + CROP_UPDATE_TABLE + "(" + UPDATE_ID + " " + "INTEGER," + WEATHER_TEMP + " " + "TEXT," + WEATHER_HUM + " " + "TEXT," + WEATHER_LIGHT + " " + "TEXT," + WEATHER_DATE + " " + "TEXT," + TREATMENT_PRUN + " " + "TEXT," + TREATMENT_WATER + " " + "TEXT," + TREATMENT_NUTRI + " " + "TEXT," + TREATMENT_PH + " " + "TEXT," + TREATMENT_FERT+ " " + "TEXT," + TREATMENT_STAGE + " " + "TEXT," + TREATMENT_NOTES + " " + "TEXT)";


    public DatabaseHelper(Context context) {
        super(context, DATABASE_NAME, null, DATABASE_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase sqLiteDatabase) {
        sqLiteDatabase.execSQL(CREATE_TABLE2);
        sqLiteDatabase.execSQL(CREATE_TABLE);
    }

    @Override
    public void onUpgrade(SQLiteDatabase sqLiteDatabase, int i, int i1) {

    }
}
