package cookit.cookit;

import android.content.Intent;
import android.graphics.Color;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.ExpandableListAdapter;
import android.widget.LinearLayout;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class RecipesActivity extends AppCompatActivity {

    TextView userNameTV;
    TextView noResultsTV;
    LinearLayout recipesContainer;

    List<Button> recipeBtns = new ArrayList<>();

    String userId = null;
    int recipeId;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_recipes);

        userId = getIntent().getStringExtra("USER_ID");

        userNameTV = (TextView) findViewById(R.id.userNameTV);
        noResultsTV = (TextView) findViewById(R.id.noResultsTV);
        recipesContainer = (LinearLayout) findViewById(R.id.recipesContainer);
    }

    @Override
    public void onStart(){
        super.onStart();

        try {
            recipeBtns.clear();
            recipesContainer.removeAllViews();
            BackgroundWorker backgroundWorker = new BackgroundWorker(this, this);
            backgroundWorker.execute("getRecipes", userId);
        }catch(Exception e){
            e.printStackTrace();
        }
    }

    @Override
    public void onBackPressed(){
        try {
            Intent intent = new Intent(this, LoginActivity.class);
            startActivity(intent);
            finish();
        }catch(Exception e){
            e.printStackTrace();
        }
    }

    public void createButtons(String btnData) {
        try {
            String[] data = btnData.split("<spliter>");

            if (data[0].equals("username")) {
                userNameTV.setText(data[1]);
            } else {
                Button btn = new Button(this);
                btn.setTextColor(Color.parseColor("#FFE1E1E1"));
                btn.setTextSize(18);
                btn.setGravity(Gravity.CENTER);
                btn.setAllCaps(false);
                btn.setText(data[0]);
                btn.setId(Integer.parseInt(data[1]));
                btn.setBackgroundColor(Color.parseColor("#FF222222"));
                btn.setPadding(5, 5, 5, 5);
                btn.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View view) {
                        recipeId = view.getId();
                        launchDetailsActivity();
                    }
                });
                recipeBtns.add(btn);
            }
        }catch(Exception e){
            e.printStackTrace();
        }
    }

    public void generateBtns(){
        try {
            LinearLayout.LayoutParams btnParams = new LinearLayout.LayoutParams(LinearLayout.LayoutParams.MATCH_PARENT, LinearLayout.LayoutParams.WRAP_CONTENT);
            btnParams.setMargins(6, 12, 6, 12);

            for (int i = 0; i < recipeBtns.size(); i++) {
                recipesContainer.addView(recipeBtns.get(i), btnParams);
            }

            if (recipeBtns.size() < 1) {
                noResultsTV.setVisibility(View.VISIBLE);
            } else {
                noResultsTV.setVisibility(View.GONE);
            }
        }catch (Exception e){
            e.printStackTrace();
        }
    }

    private void launchDetailsActivity() {
        try {
            Intent intent = new Intent(this, DetailsActivity.class);
            intent.putExtra("RECIPE_ID", Integer.toString(recipeId));
            intent.putExtra("USER_ID", userId);
            startActivity(intent);
            finish();
        }catch (Exception e){
            e.printStackTrace();
        }
    }
}
