import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintStream;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import com.restfb.Connection;
import com.restfb.DefaultFacebookClient;
import com.restfb.FacebookClient;
import com.restfb.Parameter;
import com.restfb.Version;
import com.restfb.types.Page;
import com.restfb.types.Post;

public class Quotes {
	
	
	public static void main(String[] args) throws FileNotFoundException, IOException {
		PrintStream output = new PrintStream("FbQuotes.txt");
	    
	    String accessToken = "EAACEdEose0cBAMwuaOZAIx7U5DSxOISn3SEkheegeEi6v9QVFAlQXZAeSO9ey1kH2hlbvWjCOBi1vdHQ2ikTs4zEozDW6tPDpavJ4ZAZBhr917iokXEN58ffX8OhoTFu6HZA7ZB713f3eqQ6REPr0bM5bZBnsVUutnLPd0ANPFTDpZCe2s3a8V2KtoO9ZBt6DyuYZD";
	    int count = 0;
	    FacebookClient fbClient = new DefaultFacebookClient(accessToken, Version.VERSION_2_9);
	    Page facebook_wall = fbClient.fetchObject("BQOTD",Page.class);
	    Connection<Post> feeder = fbClient.fetchConnection(facebook_wall.getId() + "/posts", Post.class, Parameter.with("limit", 100));
	    Connection<Post> postFeed = fbClient.fetchConnection(facebook_wall.getId() + "/posts", Post.class, Parameter.with("fields","reactions.limit(1000)"));
	    
	    Map<String, Post> match = new HashMap<>();
	    ArrayList<Post> total = new ArrayList<>();
	    for (List<Post> postPage: postFeed) {
	        for (Post aPost: postPage) {
	            if (aPost != null) {
	                try {
	                		Post checker = fbClient.fetchObject(aPost.getId(), Post.class, Parameter.with("fields","comments.summary(true),picture,message,reactions.limit(1000000),shares,link,created_time,permalink_url"));
	                		
	                		
	                		
	                		if (checker.getMessage() != "#Quote of the day" && checker.getMessage() != null) {
                    	 		System.out.println(checker.getMessage());
                    	 		output.print(checker.getMessage());
                    	 		output.println();
                    	 		
	                		}
	                }catch (com.restfb.exception.FacebookGraphException o) {
	                    System.out.print("");
	                }
	            }
	            System.out.println(count);
	            count++;
	            if (count == 1000) {
	            		break;
	            }
	        }
	        if (count == 1000) {
	        		break;
	        }
	    }
	    output.flush();
	}
}




