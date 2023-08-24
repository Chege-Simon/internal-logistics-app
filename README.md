<h1>Internal Logistics Application</h1>

<h2>Prerequisites</h2>
<ul>
    <li>php</li>
    <li>composer</li>
    <li>npm and node.js</li>
    <li>mysql</li>
</ul>
<p>
If using xampp place the project in the xampp folder
</p>

<h2>Set Up</h2>
<p>git clone "https://github.com/Chege-Simon/internal-logistics-app.git</p> 
<small>/****/clone project from github</small>

<p>cd into project directory</p>
<p>copy the env.example and paste as env.</p>
<p>Change (if needed):</p>
<ul>
    <li>app_name</li>
    <li>app_url</li>
    <li>app_debug (set to False for Production Env)</li>
    <li>DATABASE CONNECTIONS</li>
    <li>Session LifeTime</li>
</ul>
<p>composer install</p>
<p>php artisan migrate</p>
<p>php artisan key:generate</p>
<p>php artisan db:seed</p>
<p>npm install</p>
<p>npm run build or npm run dev</p>
<p>php artisan serve</p>

<h2>API</h2>
<h4>get api token :</h4>
<p>POST: localhost:8000/api/auth/login</p>
<p>post data must include: email, password</p> 
<small>/****/must be admin email</small>
<p>#result will contain access token that will expire in 30 minutes</p>
<p>##use access token as bearer token to access the data endpoints</p>

<h4>Data End points  <strong>#dates are mandatory</strong></h4>
<p>GET: localhost:8000/api/trip_logs/2023-01-13/2023-09-02 </p>  
<small>/****/triplogs/{from date}/{to date}</small>

<p>GET: localhost:8000/api/trips/2023-01-13/2023-09-02 </p>  
<small>/****/trips/{from date}/{to date}</small>

<p>GET: localhost:8000/api/bags/2023-01-13/2023-09-02 </p>  
<small>/****/bags/{from date}/{to date}</small>

<p>GET: localhost:8000/api/items/2023-01-13/2023-09-02 </p>  
<small>/****/items/{from date}/{to date}</small>

<p>GET: localhost:8000/api/users/2023-01-13/2023-09-02 </p>  
<small>/****/users/{from date}/{to date}</small>
