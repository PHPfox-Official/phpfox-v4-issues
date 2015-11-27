<rss version="2.0">
   <channel>
   <atom:link rel="hub" href="http://tumblr.superfeedr.com/" xmlns:atom="http://www.w3.org/2005/Atom"/>
   <description></description>
   <title>{$username}</title>
   <generator>Tumblr (3.0; @{$username})</generator>
    <link>{$basePath."".$username."/blog"}</link>
     {foreach from=$aItems item=aItem}
         <item>
             <title>{$aItem.title}</title>
             <description>&lt;p&gt;{$aItem.text}&lt;/p&gt;</description>
             <link>{$basePath."blog/".$aItem.blog_id.'/'.$aItem.title}</link>
             <guid>{$basePath."blog/".$aItem.blog_id.'/'.$aItem.title}</guid>
             <pubDate>{$aItem.pubDate}</pubDate>
         </item>
     {/foreach}
   </channel>
</rss>