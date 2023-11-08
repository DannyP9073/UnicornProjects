import React, { useState } from "react";
import { KeyboardAvoidingView, StyleSheet, TextInput, View, TouchableOpacity, Text } from "react-native";
import DatePicker from "react-native-date-picker";
import Ionicons from "react-native-vector-icons/Ionicons";
import auth from '@react-native-firebase/auth';
import firestore from "@react-native-firebase/firestore";
import { useNavigation, useRoute } from "@react-navigation/native";

const NewEntryScreen = () => {

    const user = auth().currentUser;

    const route = useRoute();

    const navigator = useNavigation();

    const [note, setNote] = useState('');
    const [water, setWater] = useState('');
    const [sunlight, setSunlight] = useState('');
    const [date, setDate] = useState(new Date());
    const [pOpen, setPOpen] = useState(false);


    const cropId = route.params.CropID;



 
    function AddEntry() {
        try {
            if(note && water && sunlight && date){
                firestore().collection('UrbanGrow_users').doc(user.uid).collection('user_crops').doc(cropId).collection('crop_entries').add({
                    note: note,
                    water: water,
                    sunlight: sunlight,
                    date: date
                }).then(() => {
                    alert('Entry added!');
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

                <TextInput placeholder="Water (ml):" 
                value={water}
                onChangeText={text => setWater(text)}
                style={styles.input} />

                <TextInput placeholder="Sunlight Hours:" 
                value={sunlight}
                onChangeText={text => setSunlight(text)}
                style={styles.input} />

                <TextInput placeholder="Notes:"
                value={note}
                onChangeText={text => setNote(text)}
                multiline={true}
                style={styles.inputArea}/>

                <View style={styles.row}>
                    <Text style={styles.dateText}> Entry Date:</Text>
                    <TouchableOpacity style={({paddingRight: 5, paddingLeft: 10, justifyContent: 'center'})} title="Open" onPress={() => setPOpen(true)}>
                        <Ionicons name="calendar" color="#ffe303" size={30} />
                    </TouchableOpacity>
                    <Text style={styles.input} onPress={() => setPOpen(true)}>{date.toDateString()}</Text>
                    <DatePicker modal open={pOpen} date={date}
                        onConfirm={(date) => {
                            setPOpen(false)
                            setDate(date)
                        }}
                        onCancel={() => {
                            setPOpen(false)
                        }}
                        mode='date'
                    />
                </View>
            </View>

            <View style={styles.buttonContainer}>
                <TouchableOpacity onPress={AddEntry}
                style={styles.button}>
                    <Text style={styles.buttonText}>Add Entry</Text>
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
    inputArea: {
        backgroundColor: 'white',
        paddingHorizontal: 15,
        paddingVertical: 10,
        borderRadius: 10,
        marginTop: 5,
        height: '30%'
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

export default NewEntryScreen;