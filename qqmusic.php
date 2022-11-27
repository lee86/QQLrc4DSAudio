<?php
/**
 * Implements the functions required by Audio Station/DSAudio.
 * ATTENTION: 此插件处于测试阶段，如有适配错误请见谅。
 * Features:
 *   - Sort result according to similarity of artist and title.     @LudySu  delete by jiangwe
 *   - Add Chinese translated lyric if {@code NEED_TRANSLATION} is {@code TRUE}.     @LudySu  delete by jiangwe
 *   - Add server for Php web to get the lyric and music list from QQ music by using Golang language.        @jiangwe
 *
 * @author Ludy Su (https://github.com/LudySu/Synology-LrcPlugin)
 * @author Jiangwe Leo (http://git.ie8.pub:8081/jiangwe/qqlrc)
 * @see https://global.download.synology.com/download/Document/DeveloperGuide/AS_Guide.pdf
 */
class LyricQQMusic {
    private $mArtist = "";
    private $mTitle = "";
    public function getLyricsList($artist, $title, $info) {
        ## 删除空格,替换为_，原为+
        $artist = str_replace(' ', '_', trim($artist));
        $title = str_replace(' ', '_', trim($title));
        $this->mArtist = $artist;
        $this->mTitle = $title;
        if ($this->isNullOrEmptyString($artist.$title)) {
            return 0;
        }
        ## 传递参数修改为 歌手_歌曲名，提高准确率
        $response = $this->download("http://music.my.local:8080/music?musicname=".rawurlencode($artist."_".$title));
        if ($this->isNullOrEmptyString($response)) {
            return 0;
        }
        ## 解析json，获取歌曲数
        $json = json_decode($response, true);
        $songArray = $json['data']['song']['list'];
        if(count($songArray) == 0) {
            return 0;
        }
        ## 解析json字段
        $foundArray = array();
        foreach ($songArray as $song) {
            $elem = array(
                'id' => $song['songmid'], # 修改为获取 songmid
                'artist' => $song['singer'][0]['name'],
                'title' => $song['songname'],
                'alt' => $song['albumname']
            );
            array_push($foundArray, $elem);
        }
        foreach ($foundArray as $song) {
            $info->addTrackInfoToList($song['artist'], $song['title'], $song['id'], $song['alt']);
        }
        return count($foundArray);
    }

    // Downloads a lyric with the SongMID.
    public function getLyrics($id, $info) {
        $lrc = $this->downloadLyric($id);
        if ($this->isNullOrEmptyString($lrc)) {
            return FALSE;
        }
        $info->addLyrics($lrc, $id);
        return true;
    }

    // Gets all lyrics
    private function downloadLyric($music_id) {
        $response = $this->download("http://music.my.local:8080/lrc?musicmid=".$music_id);
        if ($this->isNullOrEmptyString($response)) {
            return $music_id."获取失败:".$response;
        }
        $response = str_replace('[by:]', '[by: jiangwe leo]', html_entity_decode($response, ENT_QUOTES));
        $response = str_replace('&apos;', '\'', html_entity_decode($response, ENT_QUOTES)); // 恢复单引号
        return $response;
    }

    // Function for basic field validation (present and neither empty nor only white space
    private static function isNullOrEmptyString($question){
        return (!isset($question) || trim($question)==='');
    }

    // Get lyric and music list.
    private static function download($url) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ));
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
} // End