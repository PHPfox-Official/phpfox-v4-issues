
var IframePlayer =
{
    aParams: {},

    supportsVideo: function(){
        return !!document.createElement('video').canPlayType;
    },

    canPlayVideo: function(){

        return false;

        var bCanPlay = false;
        if (this.supportsVideo()){
            var v = document.createElement('video');
            if (v.canPlayType('video/mp4; codecs="avc1.42E01E, mp4a.40.2"')){
                bCanPlay = true;
            }
            else if (v.canPlayType('video/ogg; codecs="theora, vorbis"')){
                bCanPlay = true;
            }
            else if (v.canPlayType('video/webm; codecs="vp8, vorbis"')){
                bCanPlay = true;
            }
        }

        return bCanPlay;
    },

    load: function(aParams)
    {
        var sHtml = '';

        if (this.canPlayVideo()){

            sHtml += '<video width="600" height="366" preload="auto" controls autoplay>';
            sHtml += '<source type="video/webm" src="' + aParams['play'].replace('.flv', '.webm') + '">';
            sHtml += '<source type="video/mp4" src="' + aParams['play'].replace('.flv', '.mp4') + '">';
            sHtml += '<source type="video/ogg" src="' + aParams['play'].replace('.flv', '.ogg') + '">';
            sHtml += '</video>';

            document.getElementById('iframe_player').innerHTML = sHtml;

        } else {

            var sCall = '$f(\'iframe_player\', {src: \'' + aParams['url'] + 'jscript/player/flowplayer/flowplayer.swf\', wmode: \'transparent\', zIndex: -1},{';
            sCall += 'clip: {';
            sCall += 'url: \'' + aParams['play'].replace('.flv', '.mp4') + '\',';
            sCall += 'autoBuffering: true';
            sCall += '}';
            sCall += '});';

            eval(sCall);
        }
    }
};