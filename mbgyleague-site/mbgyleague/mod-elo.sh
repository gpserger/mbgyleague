#!/bin/bash

#read necessary values
read -p "Mysql database: " db
db=${db:-mbgyleague}

read -p "Player Table name: " table
table=${table:-lolplayers2}

read -p "Matches table name: " matchtable
matchtable=${matchtable:-lolmatches2}

read -p "Mysql root password: " mysqlpw
mysqlpw=${mysqlpw:-Sverige1969}

read -p "Player A ID: " A_ID
A_ID=${A_ID:-1}

read -p "Player B ID: " B_ID
B_ID=${B_ID:-2}
read -p "If A won, enter a 1. Otherwise enter a 0: " awin
awin=${awin:-1}
if [ $awin -eq "0" ]; then
	bwin=1
else
	bwin=0
fi
echo "Mysqldb: "$db
echo "player table: "$table
echo "match table: "$matchtable
echo "mysqlpw: "$mysqlpw
echo "Awin: "$awin
echo "Bwin: "$bwin
#get players' rating
Na=$(echo "SELECT summoner_name FROM $table WHERE id=$A_ID;" | mysql $db -uroot -p$mysqlpw -N)
Nb=$(echo "SELECT summoner_name FROM $table WHERE id=$B_ID;" | mysql $db -uroot -p$mysqlpw -N)
Ra=$(echo "SELECT elo FROM $table WHERE id=$A_ID;" | mysql $db -uroot -p$mysqlpw -N)
Rb=$(echo "SELECT elo FROM $table WHERE id=$B_ID;" | mysql $db -uroot -p$mysqlpw -N)
echo "Player A Summoner name: "$Na 
echo "Player A Rating: "$Ra
echo "Player B Summoner name: "$Nb
echo "Player B Rating: "$Rb

echo "#Calc Ea and Eb"
echo "Ea=1/(1+10^((Rb-Ra)/400)"
Ea="$(echo "1/(1+e((($Rb-$Ra)/400)*l(10)))" | bc -l)"
echo "Eb=1-Ea"
Eb="$(echo "1-$Ea" | bc -l)"
echo "Ea="$Ea
echo "Eb="$Eb

#Calc Ra(new) and Rb(new)
#echo "Ra(new)=Ra+(800/Nea)(W-Ea)"
#Ranew="$(echo "scale=6;$Ra+(800/$Nea)*($awin-$Ea)" | bc)"
#echo "Rb(new)=Rb+(800/Neb)(-W-Eb)"
#Rbnew="$(echo "scale=6;$Rb+(800/$Neb)*($bwin-$Eb)" | bc)"
echo "Ra(new)=Ra+160*(W-Ea)"
Ranew="$(echo "($awin-$Ea)*160+$Ra" | bc -l)"

echo "Rb(new)=Rb+160*(W-Eb)"
Rbnew="$(echo "($bwin-$Eb)*160+$Rb" | bc -l)"

echo "Ra(new)="$Ranew
echo "Rb(new)="$Rbnew

#record match
#	Determine winner
if [ $awin -eq "1" ]; then
	winner=$A_ID
else
	winner=$B_ID
fi
#record match happening and result
echo "INSERT INTO $matchtable (player_a_id,player_b_id,winner) VALUES ($A_ID,$B_ID,'$winner');" | mysql $db -uroot -p$mysqlpw
echo "Match recorded"

#record elo change for both players
echo "UPDATE $table SET elo=$Ranew WHERE id=$A_ID;" | mysql $db -uroot -p$mysqlpw
echo "UPDATE $table SET elo=$Rbnew WHERE id=$B_ID;" | mysql $db -uroot -p$mysqlpw

#count how many matches have been played: SELECT COUNT(*) FROM lolmatches2 WHERE player_a_id=1 OR player_b_id=1;
