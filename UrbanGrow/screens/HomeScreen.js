import React from "react";
import { StyleSheet, TouchableOpacity } from "react-native";
import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import CropsPage from "./pages/CropsPage";
import ProfilePage from "./pages/ProfilePage";
import Ionicons from "react-native-vector-icons/Ionicons";
import { useNavigation } from "@react-navigation/native";

const HomeScreen = () => {

    const Tab = createBottomTabNavigator();
    const navigator = useNavigation();

    return (
    <Tab.Navigator screenOptions={({ route }) => ({
        tabBarIcon: ({ focused, color, size }) => {
            let iconName;

            if (route.name === "Crops") {
              iconName = focused
                ? 'ios-list-circle'
                : 'ios-list-circle-outline';
            } else if (route.name === "Profile") {
              iconName = focused ? 'person-circle' : 'person-circle-outline';
            }

            // You can return any component that you like here!
            return <Ionicons name={iconName} size={size} color={color} />;
          },
        tabBarActiveTintColor: '#ffe303',
        tabBarInactiveTintColor: 'white',
        tabBarStyle: {
            backgroundColor: '#00cd66'
        }
      })}>
        <Tab.Screen name='Crops' component={CropsPage} options={{
            headerTitle: ("My Crops!"),
            headerTitleStyle: {
                color: '#ffe303',
                fontWeight: 'bold',
                fontSize: 20
            },
            headerStyle: {
                backgroundColor: '#00cd66'
            },
            headerRight: () => (
              <TouchableOpacity style={styles.headerButton}
                onPress={() => navigator.navigate('CreateCrop')}
                title="Add"
              ><Ionicons name="create-outline" color="#ffe303" size={30} /></TouchableOpacity>
            ),
        }}/>
        <Tab.Screen name='Profile' component={ProfilePage} options={{
            headerTitle: ("My Profile!"),
            headerTitleStyle: {
                color: '#ffe303',
                fontWeight: 'bold',
                fontSize: 20
            },
            headerStyle: {
                backgroundColor: '#00cd66'
            },
        }}/>
    </Tab.Navigator>
    );
}

export default HomeScreen;

const styles = StyleSheet.create({
    headerButton: {
        marginRight: 10
    },
});