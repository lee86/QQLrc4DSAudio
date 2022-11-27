package main

type AutoGenerated struct {
	Code                        int   `json:"code"`
	MusicSearchSearchCgiService Music `json:"music.search.SearchCgiService"`
}
type Album struct {
	ID         int    `json:"id"`
	Mid        string `json:"mid"`
	Name       string `json:"name"`
	Pmid       string `json:"pmid"`
	Subtitle   string `json:"subtitle"`
	TimePublic string `json:"time_public"`
	Title      string `json:"title"`
}

type Song struct {
	List []struct {
		Act    int    `json:"act"`
		Album  Album  `json:"album"`
		ID     int    `json:"id"`
		Mid    string `json:"mid"`
		Singer []struct {
			ID    int    `json:"id"`
			Mid   string `json:"mid"`
			Name  string `json:"name"`
			Pmid  string `json:"pmid"`
			Title string `json:"title"`
			Type  int    `json:"type"`
			Uin   int    `json:"uin"`
		} `json:"singer"`
	}
}
type Body struct {
	Song Song `json:"song"`
}
type Data struct {
	Body Body `json:"body"`
}
type Music struct {
	Data Data `json:"data"`
}

type AutoGeneratedB struct {
	Code                        int `json:"code"`
	Music struct {
		Data struct {
			Body struct {
				Song struct {
					List []struct {
						Act   int `json:"act"`
						Album struct {
							ID         int    `json:"id"`
							Mid        string `json:"mid"`
							Name       string `json:"name"`
							Pmid       string `json:"pmid"`
							Subtitle   string `json:"subtitle"`
							TimePublic string `json:"time_public"`
							Title      string `json:"title"`
						} `json:"album"`
						ID     int    `json:"id"`
						Mid    string `json:"mid"`
						Singer []struct {
							ID    int    `json:"id"`
							Mid   string `json:"mid"`
							Name  string `json:"name"`
							Pmid  string `json:"pmid"`
							Title string `json:"title"`
							Type  int    `json:"type"`
							Uin   int    `json:"uin"`
						} `json:"singer"`
					} `json:"list"`
				} `json:"song"`
			} `json:"body"`
		} `json:"data"`
	} `json:"music"`
}
