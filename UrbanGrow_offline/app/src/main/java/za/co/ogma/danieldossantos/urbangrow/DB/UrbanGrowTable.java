package za.co.ogma.danieldossantos.urbangrow.DB;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;

import static za.co.ogma.danieldossantos.urbangrow.DB.DatabaseHelper.CROP_ID;
import static za.co.ogma.danieldossantos.urbangrow.DB.DatabaseHelper.WEATHER_DATE;

public class UrbanGrowTable {
    DatabaseHelper databaseHelper;
    SQLiteDatabase sqLiteDatabase;

    public UrbanGrowTable(Context context) {
        databaseHelper = new DatabaseHelper(context);
    }

    public void openDB(){
        sqLiteDatabase = databaseHelper.getWritableDatabase();
    }
    public void closeDB(){
        sqLiteDatabase.close();
    }

    // Record Inserts ---------->
    public void insertCrop(String cpName, String cpPlant, String cpSeeds, String cpDate){
        ContentValues contentValues = new ContentValues();

        contentValues.put(DatabaseHelper.CROP_NAME, cpName);
        contentValues.put(DatabaseHelper.CROP_PLANT, cpPlant);
        contentValues.put(DatabaseHelper.CROP_SEEDS_TOTAL, cpSeeds);
        contentValues.put(DatabaseHelper.CROP_DATE, cpDate);

        sqLiteDatabase.insert(DatabaseHelper.CROP_TABLE, null, contentValues);
    }

    public void insertCropUpdate(String upID, String upwTemp, String upwHum, String upwLight, String upwDate, String uptPrun, String uptWater, String uptNutri, String uptPH, String uptFert, String uptNotes, String uptStage){
        ContentValues contentValues = new ContentValues();

        contentValues.put(DatabaseHelper.UPDATE_ID, upID);
        contentValues.put(DatabaseHelper.WEATHER_TEMP, upwTemp);
        contentValues.put(DatabaseHelper.WEATHER_HUM, upwHum);
        contentValues.put(DatabaseHelper.WEATHER_LIGHT, upwLight);
        contentValues.put(DatabaseHelper.WEATHER_DATE, upwDate);
        contentValues.put(DatabaseHelper.TREATMENT_PRUN, uptPrun);
        contentValues.put(DatabaseHelper.TREATMENT_WATER, uptWater);
        contentValues.put(DatabaseHelper.TREATMENT_NUTRI, uptNutri);
        contentValues.put(DatabaseHelper.TREATMENT_PH, uptPH);
        contentValues.put(DatabaseHelper.TREATMENT_FERT, uptFert);
        contentValues.put(DatabaseHelper.TREATMENT_NOTES, uptNotes);
        contentValues.put(DatabaseHelper.TREATMENT_STAGE, uptStage);

        sqLiteDatabase.insert(DatabaseHelper.CROP_UPDATE_TABLE, null, contentValues);
    }
    //------------>

    // Obtain Records --------->
    public Cursor getAllCrops() {
        return sqLiteDatabase.rawQuery("SELECT * FROM " + DatabaseHelper.CROP_TABLE, null);
    }

    public Cursor getCropUpdateRecords(String strID) {
        return sqLiteDatabase.rawQuery("SELECT * FROM '" + DatabaseHelper.CROP_UPDATE_TABLE + "' WHERE weatherID = " + strID, null);
    }
    //------------>

    // Update Records ------>
    public void updateCropLabel(String cpID, String cpName, String cpPlant, String cpSeeds, String cpDate) {
        ContentValues contentValues = new ContentValues();

        contentValues.put(CROP_ID, cpID);
        contentValues.put(DatabaseHelper.CROP_NAME, cpName);
        contentValues.put(DatabaseHelper.CROP_PLANT, cpPlant);
        contentValues.put(DatabaseHelper.CROP_SEEDS_TOTAL, cpSeeds);
        contentValues.put(DatabaseHelper.CROP_DATE, cpDate);

        sqLiteDatabase.update(DatabaseHelper.CROP_TABLE, contentValues, cpID + "=" + CROP_ID, null);
    }
    // -------------->

    // Delete Records ----------->
    public void deleteRecord(String cpID, String stName, String stPlant, String stSeeds, String stDate){
        sqLiteDatabase.delete(DatabaseHelper.CROP_TABLE, CROP_ID + " = ?",
                new String[]{String.valueOf(cpID)});
    }
    public void deleteEntry(String upID, String upwTemp, String upwHum, String upwLight, String upwDate, String uptPrun, String uptWater, String uptNutri, String uptPH, String uptFert, String uptNotes, String uptStage){
        sqLiteDatabase.delete(DatabaseHelper.CROP_UPDATE_TABLE, WEATHER_DATE + " = ?",
                new String[]{String.valueOf(upwDate)});
    }
    //----------------->
}
