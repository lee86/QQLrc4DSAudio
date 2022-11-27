package main

import (
	"fmt"
	"gopkg.in/yaml.v2"
	"io/ioutil"
	"log"
)

func Confget(testis bool) *Conf {
	config := new(Conf)
	yamlFile, err := ioutil.ReadFile("./conf.yml")
	if err != nil {
		log.Printf("yaml Get err #%v ", err)
	}
	err = yaml.Unmarshal(yamlFile, config)
	// err = yaml.Unmarshal(yamlFile, &resultMap)
	if err != nil {
		log.Fatalf("Unmarshal: %v", err)
	}
	if testis {
		//fmt.Println(string(yamlFile))
		fmt.Println("conf: +-+-+-+-+->>>>> ", config)
	}
	return config
}
