 <button onclick="geek()">Click me!</button> 
 <button onclick="return confirm('r u sure?');">Click me!</button> 
 <input type="submit" onclick="return confirm('r u sure?');" name="">
  
    <script> 
        function geek() { 
            confirm("Press OK to close this option"); 
        } 
    </script> 