package cookit.cookit;

import android.content.Context;
import android.os.AsyncTask;

import java.io.BufferedWriter;
import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;

/**
 * Created by asus on 14/06/2018.
 */

public class BackgroundWorker extends AsyncTask<String, Void, String> {

    Context context;
    String type;
    String str_url;
    String postData;

    private LoginActivity loginActivity;
    private RecipesActivity recipesActivity;
    private DetailsActivity detailsActivity;

    BackgroundWorker (Context ctx, LoginActivity activity) {
        context = ctx;
        loginActivity = activity;
    }
    BackgroundWorker(Context ctx, RecipesActivity activity){
        context = ctx;
        recipesActivity = activity;
    }
    BackgroundWorker(Context ctx, DetailsActivity activity){
        context = ctx;
        detailsActivity = activity;
    }

    @Override
    protected String doInBackground(String... params) {
        type = params[0];

        // 192.168.1.68
        if(type.equals("login")) {
            str_url = "http://cookit.ddns.net/android/login.php";
            // email->params[1]; password->params[2]
        } else if(type.equals("getRecipes")) {
            str_url = "http://cookit.ddns.net/android/getRecipes.php";
            // userId->params[1]
        } else if(type.equals("getDetails")){
            str_url = "http://cookit.ddns.net/android/getDetails.php";
            // recipeId->params[1]
        }

        try {
            URL url = new URL(str_url);
            HttpURLConnection httpURLConnection =  (HttpURLConnection) url.openConnection();
            httpURLConnection.setRequestMethod("POST");
            httpURLConnection.setDoInput(true);
            httpURLConnection.setDoOutput(true);

            OutputStream outputStream = httpURLConnection.getOutputStream();
            BufferedWriter bufferedWriter = new BufferedWriter(new OutputStreamWriter(outputStream, "UTF-8"));

            if(type.equals("login")) {
                postData = URLEncoder.encode("email", "UTF-8") + "=" + URLEncoder.encode(params[1], "UTF-8") + "&" + URLEncoder.encode("password", "UTF-8") + "=" + URLEncoder.encode(params[2], "UTF-8");
            }else if(type.equals("getRecipes")) {
                postData = URLEncoder.encode("userId", "UTF-8") + "=" + URLEncoder.encode(params[1], "UTF-8");
            }else if(type.equals("getDetails")){
                postData = URLEncoder.encode("recipeId", "UTF-8") + "=" + URLEncoder.encode(params[1], "UTF-8");
            }

            bufferedWriter.write(postData);
            bufferedWriter.flush();
            bufferedWriter.close();
            outputStream.close();

            InputStream inputStream = httpURLConnection.getInputStream();
            BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(inputStream, "UTF-8")); //iso-8859-1

            String result = "";
            String line;
            while ((line = bufferedReader.readLine()) != null){
                if(type.equals("login")){
                    result += line;
                }else if(type.equals("getRecipes")){
                    recipesActivity.createButtons(line);
                }else if(type.equals("getDetails")){
                    detailsActivity.manageData(line);
                }
            }

            bufferedReader.close();
            inputStream.close();
            httpURLConnection.disconnect();

            return result;
        } catch (MalformedURLException e) {
            e.printStackTrace();
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
    }

    @Override
    protected void onPostExecute(String result) {
        if(type.equals("login")){
            loginActivity.checkAuth(result);
        }else if(type.equals("getRecipes")){
            recipesActivity.generateBtns();
        }else if(type.equals("getDetails")){
            detailsActivity.generatePages();
        }
    }

    @Override
    protected void onProgressUpdate(Void... values) {
        super.onProgressUpdate(values);
    }
}
