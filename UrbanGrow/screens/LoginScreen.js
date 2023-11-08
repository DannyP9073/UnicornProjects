import React, { useState } from "react";
import { KeyboardAvoidingView, StyleSheet, Text, View, Button, TextInput, TouchableOpacity } from "react-native";
import auth from '@react-native-firebase/auth';
import { useNavigation } from "@react-navigation/core";


const LoginScreen = () => {
    const [email, setEmail] = useState('');
    const[password, setPassword] = useState('');

    const navigation = useNavigation();

    const signUpHandle = () => {
        navigation.navigate('Register');
    }

    const signInHandle = () => {
        try {
            if(email == "" || email == null){
                return alert("no email was entered")
            }else if(!((email.indexOf(".") > 0) && (email.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(email)){
                return alert("The email is invalid!")
            }else if(password == '' || password == null){
                return alert('No password was entered!')
            }else{
                auth().signInWithEmailAndPassword(email, password).then(() => {
                    console.log('User account signed in!');
                }).catch(error => {
                    if (error.code === 'auth/invalid-email') {
                        console.log('That email address is invalid!');
                    }
        
                    console.error(error);
                });
            }
        } catch (error) {
            console.error(error);
        }

    }

    return(
        <KeyboardAvoidingView style={styles.container} behavior="padding">
            <View style={styles.inputContainer}>

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
                <TouchableOpacity onPress={signInHandle}
                style={styles.button}>
                    <Text style={styles.buttonText}>Login</Text>
                </TouchableOpacity>

                <TouchableOpacity onPress={signUpHandle}
                style={[styles.button, styles.buttonOutline]}>
                    <Text style={styles.buttonOutlineText}>Register</Text>
                </TouchableOpacity>
            </View>
        </KeyboardAvoidingView>
    )
}

export default LoginScreen

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