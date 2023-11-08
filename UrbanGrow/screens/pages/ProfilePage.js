import React, {useEffect, useState} from "react";
import { StyleSheet, TouchableOpacity, View, Text, ScrollView } from "react-native";
import auth from '@react-native-firebase/auth';
import firestore from '@react-native-firebase/firestore';


const ProfilePage = () => {
    const user = auth().currentUser;

    const [email, setEmail] = useState('');
    const [name, setName] = useState('');

    useEffect(() => {
        const subscriber = firestore()
          .collection('UrbanGrow_users')
          .doc(user.uid)
          .onSnapshot(documentSnapshot => {
            setEmail(documentSnapshot.get('Email'));
            setName(documentSnapshot.get('Name'));
          });
    
        // Stop listening for updates when no longer required
        return () => subscriber();
      }, []);

    function handleSignOut() {
        auth().signOut().then(() => {
            console.log('User signed out!')
        }).catch(error => console.log(error.message));
    }

    return (
            <View style={styles.container}>
                <Text>Email: {email}</Text>
                <Text>Name: {name}</Text>
                <TouchableOpacity style={styles.button} onPress={handleSignOut}>
                    <Text style={styles.buttonText}>Sign Out</Text>
                </TouchableOpacity>
            </View>
    );
}

export default ProfilePage;

const styles = StyleSheet.create({
    headerButton: {
        marginRight: 5
    },
    containerScroll: {
        flex: 1,
    },
    container: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
    },
    button: {
        backgroundColor: '#00cd66',
        borderColor: '#ffe303',
        borderWidth: 2,
        width: '60%',
        padding: 15,
        borderRadius: 10,
        alignItems: 'center',
        marginTop: 40,
        
    },
    buttonText: {
        color: '#ffe303',
        fontWeight: '700',
        fontSize: 16,
    },
    card: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#2F2F4F',
    },
});