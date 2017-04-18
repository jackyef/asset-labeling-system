[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/dwyl/esta/issues)

Asset Labeling System
---
This an Asset Labeling System developed as part of my internship. 

It is build on CodeIgniter PHP Framework.

Check out the live-demo at: http://jackyefubuntu16.southeastasia.cloudapp.azure.com

Contact me
---
[LinkedIn](https://www.linkedin.com/in/jacky-efendi-094643a1/)

[Instagram](https://www.instagram.com/_u/jackyef_)

[![alt text][2.1]][2]
[![alt text][3.1]][3]
[![alt text][6.1]][6]

[2]: http://www.facebook.com/zhouyongchao
[3]: https://plus.google.com/+JackyEfendi1
[6]: http://www.github.com/jackyef

[1.1]: http://i.imgur.com/tXSoThF.png (twitter icon with padding)
[2.1]: http://i.imgur.com/P3YfQoD.png (facebook icon with padding)
[3.1]: http://i.imgur.com/yCsTjba.png (google plus icon with padding)
[4.1]: http://i.imgur.com/YckIOms.png (tumblr icon with padding)
[5.1]: http://i.imgur.com/1AGmwO3.png (dribbble icon with padding)
[6.1]: http://i.imgur.com/0o48UoR.png (github icon with padding)

Setup
---
1. Import the database using the .sql file provided in the `sql` folder
2. Setup your LAMP environment and copy the project folders and files into your `public_html` folder
3. Configure your hostname in `application/config/config.php`
4. Configure your database credential in `application/config/database.php`
5. Done!

What does it do?
------------
As you might already know, this system helps the user to manage a company's assets by keeping track
of the mutations history of the assets.

What are assets?
----
Basically, assets are items that can be used repeatedly. They're not consumable and usually can be used
for quite a long time. Some companies also set a certain value threshold for an item to be considered
an asset. For example, your company might not want to bother to consider a single pen as an asset, so they
might not want you to track the mutation of that item using this web-app.

What are asset mutations?
---
The definition of an asset mutation can quite vary. So we are going to define one as a base concept
that this system works on.
<br/>
<br/>
An asset mutation is an event where an asset is given to an employee for that employee hold OR when an
asset changed its location, while still being held by the same responsible employee.

<span class="fa fa-2x fa-quote-left pull-left"></span>
>Having recorded asset mutations for quite a long time in my workplace, I really think that
>tracking asset mutations history is more of a matter of being able to find <strong>WHO</strong>
>is and was responsible for holding a particular asset, rather than <strong>WHERE</strong>.
><footer>- An IT Staff at my internship workplace (2017)</footer>

Based on that quote alone, it might seems that it is enough to just record the employee information in mutations,
but it is not! If we fully rely on employee as our pointer to the assets, in the event of the employee running away,
we will have basically lose our (only) pointer to the assets!

Okay, so how would I know the location of the asset?
---
Every time a mutation occurs, the previous location and the destination of the particular mutation
are recorded. In addition, the previous employee and the destined employee are recorded as well.
This gives us the most possible available information for us to figure out the whereabout of our
assets in a certain time.

Items vs. assets?
---
An item is an asset, but an asset is not necessarily an item.
<br/>
<br/>
In this web-app, you will notice that you can enter some products information like 'item type',
'brand', 'model', 'supplier', etc. We're going to go at these one by one focusing on item type, brand, and model.
<ul>
    <li>
        Item type
        <br/>
        This is the most basic category of an item. For example: 'Smartphone', 'Power Supply Unit', 'Desktop', etc.
    </li>
    <li>
        Brand
        <br/>
        This defines the particular brand of an item type. For example: 'Xiaomi', 'Dell', 'Asus', etc.
    </li>
    <li>
        Model
        <br/>
        Finally, this is the specific model of the brand. For example: 'Redmi 3', 'Latitude 15', etc.
    </li>
</ul>
An item is basically an instance of a specific item type, a specific brand, and a specific model.
Using this scheme, you can create items like Desktop, Dell, Latitude 15, which represent the item type, brand,
and model of the item, respectively.
<br/>
<br/>
Also, each item can be supplied from a different supplier, can have their own warranty expiry date. Which makes
every instance of item can have a totally different item information, yet still has the same specification as
all the other items with the same model.

Desktops? What if one day I will take apart those kind of items?
---
Worry not! When you create an item type, you can define them as an 'assembled item'.
An assembled item can contain unlimited items inside of it.

You can remove item out of an assembled item,
and add items into it as well! Items inside can not be mutated individually, but if you mutate
the assembled item, every item inside of it will be mutated as well, and the mutation for each
of the item will also be recorded individually! This will ensure that you will still have the
mutation records even after you remove the item to be an individual item.


I see... I guess I need to try it out to learn more about it
---
Glad to hear that! Go on, try!