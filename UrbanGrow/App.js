import React, { useState, useEffect } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import LoginScreen from './screens/LoginScreen';
import RegisterScreen from './screens/RegisterScreen';
import HomeScreen from './screens/HomeScreen';
import auth from '@react-native-firebase/auth';
import ViewCropScreen from './screens/ViewCropScreen';
import NewEntryScreen from './screens/NewEntryScreen';
import CreateCropScreen from './screens/CreateCropScreen';

const Stack = createNativeStackNavigator();

const App = () => {
  const [initializing, setInitializing] = useState(true);
  const [user, setUser] = useState();

  function onAuthStateChanged(user) {
    setUser(user);
    if (initializing) {
      setInitializing(false);
    }
  }
  
  useEffect(() => {
    const subscriber = auth().onAuthStateChanged(onAuthStateChanged);
    return subscriber;
  }, []);

  return (
    <NavigationContainer>
      <Stack.Navigator>
        {user ? (
          <> 
            <Stack.Screen options={{headerShown: false}} name="Home" component={HomeScreen} />
            <Stack.Screen name="ViewCrop" options={{headerTitle: 'View Crop'}} component={ViewCropScreen} />
            <Stack.Screen name='NewEntry' options={{headerTitle: 'New Entry'}} component={NewEntryScreen} />
            <Stack.Screen name='CreateCrop' options={{headerTitle: 'Create Crop'}} component={CreateCropScreen} />
          </>
        ) : (
          <>
            <Stack.Screen options={{headerShown: false}} name="Login" component={LoginScreen} />
            <Stack.Screen name="Register" component={RegisterScreen} />
          </>
        )}
      </Stack.Navigator>
    </NavigationContainer>
  );
}

export default App;