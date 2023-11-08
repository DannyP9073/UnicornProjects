import React, { useState } from "react";
import { KeyboardAvoidingView, StyleSheet, Text, View, TextInput, TouchableOpacity } from "react-native";
import auth from '@react-native-firebase/auth';
import firestore from "@react-native-firebase/firestore";
import { useNavigation } from "@react-navigation/core";


const RegisterScreen = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [name, setName] = useState('');

    const navigation = useNavigation();

    const signUpHandle = () => {

        // Validate user email and password
        try {
            

            if(email == "" || email == null){

                return alert("no email was entered")
            }else if(!((email.indexOf(".") > 0) && (email.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(email)){

                return alert("The email is invalid!")

            }else if(name == "" || name == null){

                return alert('Name field can not be blank!')

            }else if(password == '' || password == null){

                return alert('No password was entered!')

            }else if(!/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/.test(password)){

                return alert('8 to 15 characters which contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character!')

            }else{

                auth().createUserWithEmailAndPassword(email, password).then(() => {

                    console.log('User account created & signed in!');

                    createNewUser();

                }).catch(error => {

                    if (error.code === 'auth/email-already-in-use') {  

                        console.log('That email address is already in use!');
                    }
      
                    if (error.code === 'auth/invalid-email') {
                        
                        console.log('That email address is invalid!');
                    }
      
                    console.error(error);
                });
            }
        } catch (error) {
            console.log(error);
        }
    }

    function createNewUser(){
        const user = auth().currentUser;
        try {
            if(user) {
                firestore().collection('UrbanGrow_users').doc(user.uid).set({
                    Email: email,
                    Name: name
                }).then(() => {
                    console.log('User added');
                    navigation.navigate('Home');
                });
            }
        } catch (error) {
            console.log(error);
        }
    }

    return(
        <KeyboardAvoidingView style={styles.container} behavior="padding">
            <View style={styles.inputContainer}>
            <TextInput placeholder="Name" 
                value={name}
                onChangeText={text => setName(text)}
                style={styles.input} />

                <TextInput placeholder="email" 
                value={email}
                onChangeText={text => setEmail(text)}
                style={styles.input} />

                <TextInput placeholder="password" 
                value={password}
                onChangeText={text => setPassword(text)}
                style={styles.input} 
                secureTextEntry />
            </View>

            <View style={styles.buttonContainer}>
                <TouchableOpacity onPress={signUpHandle}
                style={styles.button}>
                    <Text style={styles.buttonText}>Register</Text>
                </TouchableOpacity>
            </View>
        </KeyboardAvoidingView>
    );
}

export default RegisterScreen;

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
});