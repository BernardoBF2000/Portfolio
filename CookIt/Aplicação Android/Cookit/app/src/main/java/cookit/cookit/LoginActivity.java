package cookit.cookit;

import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class LoginActivity extends AppCompatActivity {

    Button loginButton;
    EditText loginEmail;
    EditText loginPassword;
    TextView alertError;

    int userId = -1;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        loginButton = (Button) findViewById(R.id.loginButton);
        loginEmail = (EditText) findViewById(R.id.loginEmail);
        loginPassword = (EditText) findViewById(R.id.loginPassword);
        alertError = (TextView) findViewById(R.id.alertError);
    }

    @Override
    protected void onResume(){
        super.onResume();

        if(!checkConnection()) {
            alertError.setText("É Necessário Conexão à Internet");
            alertError.setVisibility(View.VISIBLE);
        } else {
            alertError.setVisibility(View.INVISIBLE);
        }
    }

    public void login(View view) {
        String email = loginEmail.getText().toString();
        String password = loginPassword.getText().toString();

        if(!checkConnection()) {
            alertError.setText("É Necessário Conexão à Internet");
            alertError.setVisibility(View.VISIBLE);
        } else {
            alertError.setVisibility(View.INVISIBLE);

            if(isEmailValid(email)) {

                alertError.setVisibility(View.INVISIBLE);

                BackgroundWorker backgroundWorker = new BackgroundWorker(this, this);
                backgroundWorker.execute("login", email, password);
            } else {
                alertError.setText("Email Inválido");
                alertError.setVisibility(View.VISIBLE);
            }
        }
    }

    public boolean checkConnection() {
        ConnectivityManager connectivityManager = (ConnectivityManager)getSystemService(Context.CONNECTIVITY_SERVICE);
        return connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_MOBILE).getState() == NetworkInfo.State.CONNECTED || connectivityManager.getNetworkInfo(ConnectivityManager.TYPE_WIFI).getState() == NetworkInfo.State.CONNECTED;
    }

    public void checkAuth(String auth) {
        if(auth.equals("auth_failed")) {
            alertError.setText("Dados Incorretos");
            alertError.setVisibility(View.VISIBLE);
        } else if(auth.equals("connection_failed")) {
            alertError.setText("Conexão Falhou");
            alertError.setVisibility(View.VISIBLE);
        } else {
            try {
                userId = Integer.parseInt(auth);
                if(userId != -1){
                    loginPassword.setText("");
                    launchRecipesActivity();
                }
            } catch (NumberFormatException e){
                alertError.setText("Ocorreu um Erro");
                alertError.setVisibility(View.VISIBLE);
            }
        }
    }

    private static boolean isEmailValid(String email) {
        String expression = "^[\\w\\.-]+@([\\w\\-]+\\.)+[A-Z]{2,4}$";
        Pattern pattern = Pattern.compile(expression, Pattern.CASE_INSENSITIVE);
        Matcher matcher = pattern.matcher(email);
        return matcher.matches();
    }

    private void launchRecipesActivity() {
        Intent intent = new Intent(this, RecipesActivity.class);
        intent.putExtra("USER_ID", Integer.toString(userId));
        startActivity(intent);
    }
}
