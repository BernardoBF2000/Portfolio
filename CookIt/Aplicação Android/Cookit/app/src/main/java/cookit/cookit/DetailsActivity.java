package cookit.cookit;

import android.content.Intent;
import android.graphics.Color;
import android.graphics.Typeface;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.Html;
import android.view.View;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.squareup.okhttp.OkHttpClient;
import com.squareup.okhttp.Protocol;
import com.squareup.picasso.OkHttpDownloader;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

public class DetailsActivity extends AppCompatActivity {

    String recipeId;
    String userId;

    String title = "";
    String difficulty = "";
    String duration = "";
    String category = "";
    String robot = "";
    String ingredients = "";
    String img = "";
    List<String> steps = new ArrayList<>();

    int currentPage = 1;
    int numPages = 1;

    OkHttpClient client;
    Picasso picasso;

    LinearLayout content;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_details);

        getWindow().addFlags(WindowManager.LayoutParams.FLAG_KEEP_SCREEN_ON);

        recipeId = getIntent().getStringExtra("RECIPE_ID");
        userId = getIntent().getStringExtra("USER_ID");

        client = new OkHttpClient();
        client.setProtocols(Arrays.asList(Protocol.HTTP_1_1));
        picasso = new Picasso.Builder(this).downloader(new OkHttpDownloader(client)).build();

        content = (LinearLayout) findViewById(R.id.content_view);

        steps.clear();
    }

    @Override
    protected void onResume(){
        super.onResume();

        BackgroundWorker backgroundWorker = new BackgroundWorker(this, this);
        backgroundWorker.execute("getDetails", recipeId);
    }

    @Override
    public void onBackPressed(){
        Intent intent = new Intent(this, RecipesActivity.class);
        intent.putExtra("USER_ID", userId);
        startActivity(intent);
        finish();
    }

    public void backward(View view){
        if(currentPage - 1 >= 1){
            currentPage -= 1;
        }

        updateContentView();
    }

    public void forward(View view){
        if(currentPage + 1 <= numPages){
            currentPage += 1;
        }

        updateContentView();
    }

    private void updateContentView(){
        content.removeAllViews();

        if(currentPage == 1){
            TextView titleView = new TextView(this);
            titleView.setTextSize(24);
            titleView.setTypeface(Typeface.DEFAULT_BOLD);
            titleView.setTextColor(Color.parseColor("#FF222222"));
            titleView.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);
            titleView.setText("\n" + title + "\n");
            content.addView(titleView);

            if(img != "none") {
                ImageView imageView = new ImageView(this);
                imageView.setMaxHeight(200);
                imageView.setPadding(20, 0, 20, 0);
                Picasso.with(this).load(img).into(imageView);
                content.addView(imageView);
            }

            TextView categoryView = new TextView(this);
            categoryView.setTextSize(18);
            categoryView.setTextColor(Color.parseColor("#FF222222"));
            categoryView.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);
            categoryView.setText("\nCategoria:\n" + category + "\n");
            content.addView(categoryView);

            TextView durationView = new TextView(this);
            durationView.setTextSize(18);
            durationView.setTextColor(Color.parseColor("#FF222222"));
            durationView.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);
            durationView.setText("Tempo:\n" + duration + "\n");
            content.addView(durationView);

            TextView difficultyView = new TextView(this);
            difficultyView.setTextSize(18);
            difficultyView.setTextColor(Color.parseColor("#FF222222"));
            difficultyView.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);
            difficultyView.setText("Dificuldade:\n" + difficulty + "\n");
            content.addView(difficultyView);

            TextView robotView = new TextView(this);
            robotView.setTextSize(18);
            robotView.setTextColor(Color.parseColor("#FF222222"));
            robotView.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);
            robotView.setText("Robô:\n" + robot + "\n");
            content.addView(robotView);
        }else if(currentPage == 2){
            TextView header = new TextView(this);
            header.setTextSize(24);
            header.setTypeface(Typeface.DEFAULT_BOLD);
            header.setTextColor(Color.parseColor("#FF222222"));
            header.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);
            header.setText("\nIngredientes\n");
            content.addView(header);

            TextView ingredientsView = new TextView(this);
            ingredientsView.setText(Html.fromHtml("<big>" + ingredients + "</big>"));
            ingredientsView.setTextSize(14);
            ingredientsView.setPadding(20, 0, 20, 0);
            content.addView(ingredientsView);
        }else if(currentPage >= 3 && currentPage <= numPages){
            TextView header = new TextView(this);
            header.setTextSize(24);
            header.setTypeface(Typeface.DEFAULT_BOLD);
            header.setTextColor(Color.parseColor("#FF222222"));
            header.setTextAlignment(View.TEXT_ALIGNMENT_CENTER);
            header.setText("\nPasso " + (currentPage - 2) + "\n");
            content.addView(header);

            TextView stepView = new TextView(this);
            stepView.setText(Html.fromHtml("<big>" + steps.get(currentPage - 3) + "</big>"));
            stepView.setTextSize(14);
            stepView.setPadding(20, 0, 20, 0);
            content.addView(stepView);
        }
    }

    public void manageData(String recipeData){
        String[] data = recipeData.split("<spliter>");

        if(data[0].equals("title")){
            title = data[1];
        }
        if(data[0].equals("dificulty")){
            difficulty = data[1];
        }
        if(data[0].equals("duration")){
            duration = data[1];
        }
        if(data[0].equals("category")){
            category = data[1];
        }
        if(data[0].equals("robot")){
            robot = data[1];
        }
        if(data[0].equals("ingredients")){
            ingredients = data[1];
        }
        if(data[0].equals("img")){
            img = data[1];
        }
        if(data[0].equals("step")){
            steps.add(data[1]);
        }
    }

    public void generatePages(){
        currentPage = 1;
        numPages = steps.size() + 2;

        updateContentView();
    }
}
