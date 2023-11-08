import React, { useEffect, useState } from "react";
import { StyleSheet, View, Text, ActivityIndicator, FlatList, TouchableOpacity } from "react-native";
import firestore from '@react-native-firebase/firestore';
import auth from '@react-native-firebase/auth';
import { useNavigation } from "@react-navigation/native";


const CropsPage = () => {
    const getUser = auth().currentUser;
    const [loading, setLoading] = useState(true); // Set loading to true on component mount
    const [crops, setCrops] = useState([]); // Initial empty array of users
  const navigator = useNavigation();

    useEffect(() => {
        const user = getUser.uid;
        const subscriber = firestore()
          .collection('UrbanGrow_users').doc(user).collection('user_crops').onSnapshot(querySnapshot => {
            const crops = [];
      
            querySnapshot.forEach(documentSnapshot => {
              crops.push({
                ...documentSnapshot.data(),
                key: documentSnapshot.id,

              });
            });
      
            setCrops(crops);
            setLoading(false);
          });
      
        // Unsubscribe from events when no longer in use
        return () => subscriber();
      }, []); 
    if (loading) {
      return <ActivityIndicator />;
    }

    function ViewCrop(cropId, uid){
      navigator.navigate('ViewCrop', {
        CropID: cropId,
        UID: uid
      });
    }

    return (
        <FlatList
          data={crops}
          renderItem={({ item }) => (
                <TouchableOpacity style={styles.cardButton}
                onPress={() => 
                          ViewCrop(item.key, getUser.uid)
                        }>
                    <View style={{ padding: 5, justifyContent: 'center'}}>            
                      <Text style={styles.cropTextHead}>{item.crop_names}</Text>
                      <View style={{flexDirection: 'row', padding: 5}}>
                        <Text style={{flex: 1, fontSize: 15}}>Seeds Planted: </Text>
                        <Text style={styles.cropText}>{item.seeds_planted}</Text>
                      </View>
                      <View style={{flexDirection: 'row', padding: 5}}>
                        <Text style={{flex: 1, fontSize: 15}}>Date Planted: </Text>
                        <Text style={styles.cropText}>{item.plant_date.toDate().toDateString()}</Text>
                      </View>               
                    </View>
                </TouchableOpacity>
          )}
        />
    );
}

export default CropsPage;

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
    cardButton: {
        flex: 1,
        backgroundColor: '#00cd66',
        margin: 10,
        borderRadius: 10,
        borderColor: '#ffe303',
        borderWidth: 5
    },
    cropTextHead: {
      fontSize: 25,
      fontWeight: 'bold',
      alignSelf: 'center'
    },
    cropText: {
      fontSize: 15,
    }
});