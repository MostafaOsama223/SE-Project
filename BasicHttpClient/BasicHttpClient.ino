/**
   BasicHTTPClient.ino

    Created on: 24.05.2015

*/

#include <Arduino.h>

#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>

#include <ESP8266HTTPClient.h>

#include <WiFiClient.h>

ESP8266WiFiMulti WiFiMulti;

char sendBtn = D2, roadBtn = D1, trafficBtn = D0;
int road = 1, traffic = 0;
unsigned long lastPressTime = 0;
byte btnState = B00000000;
void setup() {

  pinMode(D0, INPUT_PULLUP);
  pinMode(D1, INPUT_PULLUP);
  pinMode(D2, INPUT_PULLUP);
  
  Serial.begin(115200);
  // Serial.setDebugOutput(true);

  Serial.println();
  Serial.println();
  Serial.println();

  for (uint8_t t = 4; t > 0; t--) {
    Serial.printf("[SETUP] WAIT %d...\n", t);
    Serial.flush();
    delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("WE0C41B0", "kc197276");

}

void loop() {
  // wait for WiFi connection
  btnState = digitalRead(D0) | (digitalRead(D1) << 1) | (digitalRead(D2) << 2);
//  Serial.println(btnState);
  switch (btnState){
    case 6: //Change road
      if(!checkBounce())  road ++;
      break;
    case 5: //Change traffic
      if(!checkBounce())  traffic = (traffic+1)%3;
      break;
    case 3: //Send data
      if(!checkBounce())  sendData();
      break;
    default:
      break;    
  }
//  sendData();
  delay(10);
}

bool checkBounce(){
  
  if(millis() - lastPressTime > 70){
    Serial.println("tmam");
    lastPressTime = millis();
    return false;
  }else{
    lastPressTime = millis();
    return true;
  }
}

void sendData (){
    if ((WiFiMulti.run() == WL_CONNECTED)) {
      
    WiFiClient client;
    HTTPClient http;
    String url = "http://192.168.1.5/se-project/changeRoad.php?id=" + String(road) + "&status=" + String(traffic);

    Serial.print("[HTTP] begin...\n");
    if (http.begin(client, url)) {  // HTTP

      Serial.print("[HTTP] GET...\n");
      // start connection and send HTTP header
      int httpCode = http.GET();

      // httpCode will be negative on error
      if (httpCode > 0) {
        // HTTP header has been send and Server response header has been handled
        Serial.printf("[HTTP] GET... code: %d\n", httpCode);

        // file found at server
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String payload = http.getString();
          Serial.println(payload);
        }
      } else {
        Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
      }

      http.end();
    } else {
      Serial.printf("[HTTP} Unable to connect\n");
    }
  }
}
