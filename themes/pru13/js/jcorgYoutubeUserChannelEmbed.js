/**
 * jquery.jcorgYoutubeUserChannel.js
 * Copyright (c) 2012 Jaspreet Chahal (http://jaspreetchahal.org/)
 * Licensed under the Free BSD License 
 * @author Jaspret Chahal
 * @projectDescription    jQuery plugin to allow custom youtube channel embed
 * @documentation http://jaspreetchahal.org/jquery-plugin-youtube-channel-embed
 * @version 1.1
 * @requires jquery.js (tested with v 1.7.2)
 * NOT AFFILIATED WITH YOUTUBE
 * YOU MUST KEEP THIS COMMENT SECTION WHEN USING THIS PLUGIN AND A LINK BACK WILL BE APPRECIATED
 */
 (function($) {      
      jQuery.fn.jcorgYoutubeUserChannelEmbed = function(settings) {
        settings = jQuery.extend({
          mode:'thumbnails', // list || thumbnails
          videoWidth:'640',
          thumbnailWidth:'200',
          videoWidth:'640',
          showTitle:true,
          maxResults:4,
          startIndex:1,
          autoPlay:false, 
          orderBy:'published', // relevance | published | viewCount | rating
          filterKeyword:'', // just in case you want to filter videos by keyword in a channel being embedded
          channelUserName:'jompantau',
          onlyHD:false,
          allowFullScreen:true,
          format:'embed', // embed | mobileH263 | mobileMP4
          useIncl:'frame' // object || frame
        },settings);
        var allowfullscreen = settings.allowfullscreen?'allowfullscreen':'';
        var url = 'http://gdata.youtube.com/feeds/users/';
        var autoplay = settings.autoPlay?'1':0;
        var youtubeParams = [
                              "alt=json",
                              "start-index="+settings.startIndex,
                              "max-results="+settings.maxResults,
                              "orderby="+settings.orderBy
                            ];
        if(settings.format == 'embed') 
            youtubeParams.push("format=5");        
        else if(settings.format == 'mobileH263') 
            youtubeParams.push("format=1");        
        else if(settings.format == 'mobileMP4') 
            youtubeParams.push("format=3");
        if(settings.filterKeyword.length > 0)
            youtubeParams.push("q="+filterKeyword);
        // HD
        if(settings.onlyHD) 
            youtubeParams.push("hd=true"); 
        // JSONP callback  
        youtubeParams.push("callback=?")       
        url = url + settings.channelUserName +"/uploads?" + youtubeParams.join('&');
        parentElement = jQuery(this);  
        autoplay = false;
        return this.each(function(){
            jQuery.getJSON(url,function(data) {
              if(settings.mode == "list") {
                var listObj = jQuery('<ul />',{class:"jcorg-yt-list"}).appendTo(parentElement); 
                if(data.feed.entry != undefined) {
                  for (var i = 0; i < data.feed.entry.length; i++) {
                       var entry = data.feed.entry[i];
                       var vidID= (entry ? entry.id.$t : '');
                       var vidCategory= (entry ? entry.media$group.media$category[0].label : '');
                       var vidLink=    (entry ? entry.media$group.media$player[0].url : '');
                       var vidTitle=    (entry ? entry.media$group.media$title.$t : '');
                       var vidThumb=    (entry ? entry.media$group.media$thumbnail[1].url : '');
                       var vidDuration= (entry ? entry.media$group.yt$duration.seconds : 0);
                       var vidViews=    (entry && entry.yt$statistics ? entry.yt$statistics.viewCount : 0);
                       
                       if(settings.showTitle)
                        jQuery("<li/>",{class:"jcorg-yt-list-title"}).html(vidTitle).appendTo(listObj);                       

                       if(settings.useIncl == 'frame') {
                          if ( vidID.substr(0,38) == 'http://gdata.youtube.com/feeds/videos/' ) vidLink = 'http://www.youtube.com/embed/' + vidID.substr(38); 
                          var allowfullscreen = (settings.allowFullScreen)?'allowfullscreen':''; 
                          ytObject = '<iframe width="'+settings.videoWidth+'" height="'+(parseInt(settings.videoWidth/1.78))+'" src="'+vidLink+'?feature=player_detailpage&origin='+(window.location.origin)+'" autoplay="'+autoplay+'" frameborder="0" '+allowfullscreen+'></iframe>';
                       }
                       else {
                              if ( vidLink.substr(0,31) == 'http://www.youtube.com/watch?v=' ) vidLink = 'http://www.youtube.com/v/' + vidLink.substr(31);  
                              var allowfullscreen = (settings.allowFullScreen)?'true':'false'; 
                              var ytObject = '<object width="'+settings.videoWidth+'" height="'+(parseInt(settings.videoWidth/1.78))+'">' +    
                                    '<param name="movie" value="'+vidLink+'?hl=en&fs=1&autoplay='+autoplay+'"></param>' +   
                                    '<param name="allowFullScreen" value="'+allowfullscreen+'"></param>' +   
                                    '<param name="allowscriptaccess" value="always"></param>' +   
                                    '<embed src="'+vidLink+'?hl=en&fs=1&autoplay='+autoplay+'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="'+allowfullscreen+'" width="'+settings.videoWidth+'" height="'+(parseInt(settings.videoWidth/1.78))+'"></embed>' + 
                                    '</object>';
                       }             
                       jQuery("<li/>",{class:"jcorg-yt-list-video"}).html(ytObject).appendTo(listObj);                   
                    };
                }
              }
              else if(settings.mode == "thumbnails") {
                var listObj = jQuery('<div />',{class:"jcorg-yt-default-play"}).appendTo(parentElement); 
                var listObj = jQuery('<ul />',{class:"jcorg-yt-thumbnails clearfix"}).appendTo(parentElement); 
                var vidArray = [];
                if(data.feed.entry != undefined) {
                  for (var i = 0; i < data.feed.entry.length; i++) {
                       var entry = data.feed.entry[i];
                       
                       vidID= (entry ? entry.id.$t : '');
                       vidCategory= (entry ? entry.media$group.media$category[0].label : '');
                       vidLink=    (entry ? entry.media$group.media$player[0].url : '');
                       vidTitle=    (entry ? entry.media$group.media$title.$t : '');
                       vidThumb=    (entry ? entry.media$group.media$thumbnail[1].url : '');
                       vidDuration= (entry ? entry.media$group.yt$duration.seconds : 0);
                       vidViews=    (entry && entry.yt$statistics ? entry.yt$statistics.viewCount : 0);
                       vid = '<a href="'+vidLink+'" rel="prettyPhoto[gallery]" title="'+vidTitle+'" class="jcorg-yt-thumbnail"><img src="'+vidThumb+'" alt="'+vidTitle+'" width="'+settings.thumbnailWidth+'" height="'+(parseInt(settings.thumbnailWidth/1.34))+'" /></a>'; 
                       if(settings.showTitle) {
                          vid = vid+'<div class="jcorg-yt-thumbnail-title" style="width:'+settings.thumbnailWidth+'px !important">'+vidTitle+'</div>';
                       }
                       jQuery("<li/>").html(vid).appendTo(listObj);

                  }
                  jQuery("a[rel^='prettyPhoto']").prettyPhoto({
                              social_tools:false,
                               autoplay:settings.autoPlay,
                               default_width:settings.videoWidth,
                               default_height:(parseInt(settings.videoWidth/1.78)),
                               show_title:false
                            });
                }

              }
            });
        });  
      }
  
})( jQuery );
