import React, { useState } from "react";
import { KeyboardAvoidingView, StyleSheet, TextInput, View, TouchableOpacity, Text } from "react-native";
import DatePicker from "react-native-date-picker";
import Ionicons from "react-native-vector-icons/Ionicons";
import auth from '@react-native-firebase/auth';
import firestore from "@react-native-firebase/firestore";
import { useNavigation } from "@react-navigation/native";

const CreateCropScreen = () => {

    const user = auth().currentUser;
    const navigator = useNavigation();

    const [cropName, setCropName] = useState('');
    const [seedsPlanted, setSeedsPlanted] = useState('');
    const [pDate, setPDate] = useState(new Date());
    const [location, setLocation] = useState('');
    const [hDate, setHDate] = useState(new Date());
    const [pOpen, setPOpen] = useState(false);
    const [hOpen, setHOpen] = useState(false);

    function AddCrop() {
        try {
            if(!/[0-9]/.test(seedsPlanted)){

                return alert('Number of seeds planted must be a number!')

            }else if(cropName && seedsPlanted && pDate && location && hDate){

                firestore().collection('UrbanGrow_users').doc(user.uid).collection('user_crops').add({
                    crop_names: cropName,
                    harvest_date: hDate,
                    location: location,
                    plant_date: pDate,
                    seeds_planted: seedsPlanted
                }).then(() => {
                    console.log('Crop added!');
                    navigator.goBack();
                });

            } else {

                alert('Missing information!')
                
            }
        } catch (error) {
            console.log(error)
        }
    }

    return (
        <KeyboardAvoidingView style={styles.container} behavior="padding">
            <View style={styles.inputContainer}>

                <TextInput placeholder="Plant Type:" 
                value={cropName}
                onChangeText={text => setCropName(text)}
                style={styles.input} />

                <TextInput placeholder="Number of seeds Planted:" 
                value={seedsPlanted}
                onChangeText={text => setSeedsPlanted(text)}
                style={styles.input} />

                <TextInput placeholder="Location of crop:"
                value={location}
                onChangeText={text => setLocation(text)}
                style={styles.input}/>

                <View style={styles.row}>
                    <Text style={styles.dateText}> Date Planted:</Text>
                    <TouchableOpacity style={({paddingRight: 5, paddingLeft: 10, justifyContent: 'center'})} title="Open" onPress={() => setPOpen(true)}>
                        <Ionicons name="calendar" color="#ffe303" size={30} />
                    </TouchableOpacity>
                    <Text style={styles.input} onPress={() => setPOpen(true)}>{pDate.toDateString()}</Text>
                    <DatePicker modal open={pOpen} date={pDate}
                        onConfirm={(pDate) => {
                            setPOpen(false)
                            setPDate(pDate)
                        }}
                        onCancel={() => {
                            setPOpen(false)
                        }}
                        mode='date'
                    />
                </View>
                <View style={styles.row}>
                    <Text style={styles.dateText}> Harvest Date:</Text>
                    <TouchableOpacity style={({paddingRight: 5, paddingLeft: 10, justifyContent: 'center'})} title="Open" onPress={() => setHOpen(true)}>
                        <Ionicons name="calendar" color="#ffe303" size={30} />
                    </TouchableOpacity>
                    <Text style={styles.input} onPress={() => setHOpen(true)}>{hDate.toDateString()}</Text>
                    <DatePicker modal open={hOpen} date={hDate}
                        onConfirm={(hDate) => {
                            setHOpen(false)
                            setHDate(hDate)
                        }}
                        onCancel={() => {
                            setHOpen(false)
                        }}
                        mode='date'
                    />
                </View>
            </View>

            <View style={styles.buttonContainer}>
                <TouchableOpacity onPress={AddCrop}
                style={styles.button}>
                    <Text style={styles.buttonText}>Add Crop</Text>
                </TouchableOpacity>
            </View>
        </KeyboardAvoidingView>
    );
}

const styles = StyleSheet.create({
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#00cd66'
    },

    inputContainer: {
        width: '80%',
    },
    input: {
        backgroundColor: 'white',
        paddingHorizontal: 15,
        paddingVertical: 10,
        borderRadius: 10,
        marginTop: 5,
    },
    buttonContainer: {
        width: '60%',
        justifyContent: 'center',
        alignItems: 'center',
        marginTop: 40,
    },
    button: {
        backgroundColor: '#ffe303',
        width: '100%',
        padding: 15,
        borderRadius: 10,
        alignItems: 'center',
    },
    buttonOutline: {
        backgroundColor: 'white',
        marginTop: 5,
        borderColor: '#ffe303',
        borderWidth: 2,
    },
    buttonText: {
        color: 'white',
        fontWeight: '700',
        fontSize: 16,
    },
    buttonOutlineText: {
        color: '#ffe303',
        fontWeight: '700',
        fontSize: 16,
    },
    row: {
        flexDirection: 'row',
        padding: 5
    },
    dateText: {
        alignSelf: 'center',
        justifyContent: 'center',
        fontFamily: 'Arial Rounded MT Bold',
        fontSize: 15
    }
});

export default CreateCropScreen;