package main

import "flag"

var conf = Confget(false)
var testis = flag.Bool("test", false, "")

func main() {
	flag.Parse()
	if flag.Parsed() {
		if *testis {
			test()
			return
		}
		if conf.Net.Port == "" {
			conf.Net.Port = "8080"
		}
		listenhttp(":" + conf.Net.Port)
		//select {}
	}

}
