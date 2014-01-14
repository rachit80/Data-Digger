import java.net.*;
import java.io.*;

public class multithreads 
{
	public static void main(String args[])
	{
		try{
			URL phpUrl = new URL("http://localhost/DATA_DIGGER/twitterDataFetcher.php");
			URLConnection urlCon = phpUrl.openConnection();
			urlCon.getInputStream();
        
			//FOR WORDS
			//passes offset from where the records are t be taken from the database.
			Thread t1=new Thread(new Words(0));
			Thread t2=new Thread(new Words(2));
			//Thread t3=new Thread(new Java2MySql(4));
		
			t1.start();
			t2.start();
			//t3.start();
		
			//FOR PHRASES
			Thread t4=new Thread(new Phrases(0));
			t4.start();
		}
		catch(Exception e)
		{
			e.printStackTrace();
		}
	}
}
