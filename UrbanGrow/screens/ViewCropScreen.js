import { useNavigation, useRoute } from "@react-navigation/native";
import React, {useEffect, useState, useCallback} from "react";
import { View, Text, StyleSheet, FlatList, TouchableOpacity, ActivityIndicator, RefreshControl } from "react-native";
import firestore from '@react-native-firebase/firestore';
import DatePicker from "react-native-date-picker";
import Ionicons from "react-native-vector-icons/Ionicons";

const ViewCropScreen = () => {

    const route = useRoute();

    const navigator = useNavigation();

    const [newDate, setDate] = useState(new Date());
    const [open, setOpen] = useState(false);

    const [cropName, setCropName] = useState('');
    const [seeds, setSeeds] = useState('');
    const [pdate, setPDate] = useState(new Date());
    const [location, setLocation] = useState('');
    const [loading, setLoading] = useState(true);
    const [entries, setEntries] = useState([]);

    const [refreshing, setRefreshing] = useState(false);
  
    const id = route.params.CropID;

    const wait = (timeout) => {

        FetchEntries();
        return new Promise(resolve => setTimeout(resolve, timeout));
      }

    const onRefresh = useCallback(() => {
        setRefreshing(true);
        wait(800).then(() => setRefreshing(false));
      }, []);

// event listner for fetching crop date
    useEffect(() => {

        const subscriber = firestore()
          .collection('UrbanGrow_users')
          .doc(route.params.UID).collection('user_crops').doc(route.params.CropID)
          .onSnapshot(documentSnapshot => {


            setCropName(documentSnapshot.get('crop_names'));
            setSeeds(documentSnapshot.get('seeds_planted'));
            try {
                setPDate(documentSnapshot.get('plant_date').toDate());
                setDate(documentSnapshot.get('harvest_date').toDate());

            } catch (error) {
                console.log(error)
            }
            setLocation(documentSnapshot.get('location'));

            setLoading(false);
          });
          
        return () => subscriber();
      }, []);

// event listner for fetching entries
    useEffect(() => {
        const subscriber = firestore()
        .collection('UrbanGrow_users').doc(route.params.UID).collection('user_crops').doc(route.params.CropID)
        .collection('crop_entries').orderBy('date', 'desc')
        .onSnapshot(querySnapshot => {
            const entries = [];
  
            querySnapshot.forEach(documentSnapshot => {
                entries.push({
                    ...documentSnapshot.data(),
                    key: documentSnapshot.id,
                });
            });
  
            setEntries(entries);
            setLoading(false);
        });
  
        return () => subscriber();
    }, []);

      if (loading) {
        return <ActivityIndicator />;
      }

      function FetchEntries(){
        firestore()
        .collection('UrbanGrow_users').doc(route.params.UID)
        .collection('user_crops').doc(route.params.CropID)
        .collection('crop_entries').orderBy('date', 'desc').get().then(querySnapshot => {
            const entries = [];

            querySnapshot.forEach(documentSnapshot => {
                entries.push({
                    ...documentSnapshot.data(),
                    key: documentSnapshot.id,

                });
            });

            setEntries(entries);
        });
      }

    function UpdateCrop() {
        try {
            firestore().collection('UrbanGrow_users').doc(route.params.UID)
            .collection('user_crops').doc(route.params.CropID).set({
                harvest_date: newDate,
                crop_names: cropName,
                location: location,
                plant_date: pdate,
                seeds_planted: seeds
            }).then(() => {
                alert('Updated Crop!')
            });
        } catch (error) {
            console.log(error)
        }
    }

    function DeleteCrop() {
        try {
            firestore().collection('UrbanGrow_users').doc(route.params.UID)
            .collection('user_crops').doc(route.params.CropID).delete().then(() => {
                alert('Crop deleted!');
                navigator.goBack();
            });
        } catch (error) {
            console.log(error)
        }
    }

    function DeleteEntry(key){
        try {
            firestore().collection('UrbanGrow_users').doc(route.params.UID)
            .collection('user_crops').doc(route.params.CropID).collection('crop_entries').doc(key).delete().then(() => {
                alert('Entry deleted!');
            });
        } catch (error) {
            console.log(error)
        }
    }

    return (
        <View style={styles.container}>
            <Text style={styles.heading}>{cropName}</Text>
            <View style={styles.cropView}>
                <View style={styles.row}>
                    <Text style={styles.rowText}>Date Planted:</Text>
                    <Text style={styles.rowText2}>{pdate.toDateString()}</Text>
                </View>
                <View style={styles.row}>
                    <Text style={styles.rowText}>Number of Seeds Planted:</Text>
                    <Text style={styles.rowText2}>{seeds}</Text>
                </View>
                <View style={styles.row}>
                    <Text style={styles.rowText}>Location:</Text>
                    <Text style={styles.rowText2}>{location}</Text>
                </View>
                <View style={styles.row}>
                    <Text style={styles.rowText}>Harvest Date:</Text>
                    <TouchableOpacity style={({paddingRight: 5, paddingLeft: 10})} title="Open" onPress={() => setOpen(true)}>
                        <Ionicons name="calendar" color="#ffe303" size={30} />
                    </TouchableOpacity>
                    <Text style={styles.rowText2}>{newDate.toDateString()}</Text>
                    <DatePicker modal open={open} date={newDate}
                        onConfirm={(newDate) => {
                            setOpen(false)
                            setDate(newDate)
                        }}
                        onCancel={() => {
                            setOpen(false)
                        }}
                        mode='date'
                    />
                </View>
                <View style={({justifyContent: 'center', alignItems: 'center'})}>
                <View style={styles.row}>
                    <TouchableOpacity style={styles.button} onPress={() => navigator.navigate('NewEntry', {
                        CropID: id,
                    })}>
                        <Text style={styles.buttonText}>New Entry</Text>
                    </TouchableOpacity>
                    <TouchableOpacity style={styles.buttonIcon} onPress={() => DeleteCrop(newDate)}>
                        <Ionicons name="trash" color='black' size={30} />
                    </TouchableOpacity>
                    <TouchableOpacity style={styles.buttonIcon} onPress={() => UpdateCrop(newDate)}>
                        <Ionicons name="save" color='black' size={30} />
                    </TouchableOpacity>
                </View>
                </View>
            </View>
            <FlatList
            data={entries}
            renderItem={({ item }) => (
                <View style={styles.entryView}> 
                <View style={{borderBottomColor: 'black', borderBottomWidth: StyleSheet.hairlineWidth}}/>
                    <View style={styles.entryRow}>                   
                        <Text style={styles.entryTextDef}>water(ml): </Text>
                        <Text style={styles.entryText}>{item.water}</Text>
                    </View>
                    <View style={styles.entryRow}>
                        <Text style={styles.entryTextDef}>sunlight(hours):</Text>
                        <Text style={styles.entryText}>{item.sunlight}</Text>
                    </View>
                    <View style={styles.entryRow}>
                        <Text style={styles.entryTextDef}>Date:</Text>
                        <Text style={styles.entryText}>{item.date.toDate().toDateString()}</Text>
                    </View>
                    <View>
                        <Text style={styles.entryTextDef}>Note:</Text>
                        <Text style={styles.entryText}>{item.note}</Text>
                    </View>

                    <TouchableOpacity style={styles.entryIcon} onPress={() => DeleteEntry(item.key)}>
                        <Ionicons name="trash-bin" color='black' size={30} />
                    </TouchableOpacity>
                </View>
            )} refreshControl={<RefreshControl
                refreshing={refreshing}
                onRefresh={onRefresh}
              />}/>
        </View>       
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: '#00cd66',
    },
    cropView: {
        margin: 5,
    },
    heading: {
        fontFamily: 'Arial Rounded MT Bold',
        fontSize: 40,
        fontWeight: 'bold',
        color: '#ffe303',
        alignSelf: 'center',
        padding: 5,
    },
    row: {
        flexDirection: 'row',
        padding: 5
    },
    rowText: {
        flex: 1,
        fontFamily: 'Arial Rounded MT Bold',
        fontSize: 16
    },
    rowText2: {
        fontFamily: 'Arial Rounded MT Bold',
        fontSize: 16
    },
    button: {
        margin: 10,
        backgroundColor: '#ffe303',
        width: '50%',
        padding: 15,
        borderRadius: 10,
        alignItems: 'center',
        alignSelf: 'center'
    },
    buttonIcon: {
        marginTop: 10,
        marginBottom: 10,
        marginLeft: 8,
        backgroundColor: '#ffe303',
        width: '20%',
        padding: 5,
        borderRadius: 10,
        alignItems: 'center',
        justifyContent: 'center'
    },
    buttonText: {
        fontWeight: '700',
        fontSize: 16,
    },
    input: {
        fontFamily: 'Arial Rounded MT Bold',
        fontSize: 16,
        backgroundColor: 'white',
        paddingHorizontal: 15,
        paddingVertical: 10,
        borderRadius: 10,
        marginTop: 5,
        width: '40%',
    },
    entryView: {
        flex: 1,
        margin: 10,
    },
    entryRow: {
        flexDirection: "row",
    },
    entryTextDef: {
        flex: 1,
        fontFamily: 'Arial Rounded MT Bold',
        padding: 2,
        alignSelf: 'center',
        fontWeight: 'bold'
    },
    entryText: {
        fontFamily: 'ArialMT',
        padding: 3,
        alignSelf: 'center'
    },
    entryIcon: {
        alignSelf: 'flex-end',
        margin: 2,
    }

});

export default ViewCropScreen;