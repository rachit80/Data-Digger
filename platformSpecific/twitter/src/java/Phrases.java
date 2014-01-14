import java.sql.*;
import java.io.*;
import java.util.*;

public class Phrases implements Runnable
{
	int num;
	public Phrases(int x)
	{
		num=x;
	}
	public void run()
	{
		String url = "jdbc:mysql://localhost:3306/";//The JDBC driver gives out the connection to the database and implements the protocol for 
													//transferring the query and result between client and database.
        String dbName = "Words/Phrases";
        String driver = "com.mysql.jdbc.Driver";
        String userName = "root";
        String password = "";
        try 
        {
        	Class.forName(driver).newInstance();
        	Connection conn = DriverManager.getConnection(url+dbName,userName,password);
        	Statement st = conn.createStatement();
        	int t=0;
            ResultSet res = st.executeQuery("SELECT * FROM Phrases LIMIT "+num+",2 ");
            //takes the offset from the multithreads.java program and the 2 mentions the no of records to
            //be taken from that offset
            
            while (res.next()) //res initially point to NULL
            {
            	String msg = res.getString("Phrase");
            	int value = res.getInt("P_value");
            	//System.out.println(msg+value);
            	String filename="C:/xampp/htdocs/DATA_DIGGER/yogi.txt";//file name containing the tweets
            	FileReader fileReader=new FileReader(filename);
            	
            	BufferedReader bufferedReader = new BufferedReader(fileReader);
            	String line;
            	int count=0;
            	
            	while((line=bufferedReader.readLine())!=null) 
            	{
            		
            		if(line.toLowerCase().contains(msg.toLowerCase()))//for case insensitive matching
            		{
            			count++;
            			//System.out.println(line + value);
            		}
            	}
            	value*=count;
            	
            	System.out.println(msg + "\t" + value);
            	 bufferedReader.close();
            }
        	conn.close();
        } 
        catch (Exception e) 
        {
        	e.printStackTrace();
        } 
	}

}
