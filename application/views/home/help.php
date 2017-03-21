<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 3/9/2017
 * Time: 9:26 AM
 */
?>

<div class="row">
    <div class="col-sm-12">
    <div class="pull-left">
        <ol class="breadcrumb">
            <li><a href="<?= base_url()?>">Home</a></li>
            <li><a href="<?= base_url().'help'?>">Help</a></li>
        </ol>
    </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-8">
        <div class="panel panel-collapse panel-default" style="border-color: #229955;">
            <div class="panel-heading" style="background-color: #229955">
                <h3 class="panel-title" style="color: white">Help</h3>
            </div>
            <div class="panel-body">
                <div class="col-sm-12" id="what-is-this">
                    <h3 >So... what is this?</h3>
                    <p>
                        As you might already know, this system helps the user to manage a company's assets by keeping track
                        of the mutations history of the assets.
                    </p>
                    <hr/>
                </div>

                <div class="col-sm-12" id="assets">
                    <h3 >What are assets?</h3>
                    <p>
                        Basically, assets are items that can be used repeatedly. They're not consumable and usually can be used
                        for quite a long time. Some companies also set a certain value threshold for an item to be considered
                        an asset. For example, your company might not want to bother to consider a single pen as an asset, so they
                        not want you to track the mutation of that item using this web-app.
                    </p>
                    <hr/>
                </div>

                <div class="col-sm-12" id="mutations">
                    <h3 >What are asset mutations?</h3>
                    <p>
                        The definition of an asset mutation can quite vary. So we are going to define one as a base concept
                        that this system works on.
                        <br/>
                        <br/>
                        An asset mutation is an event where an asset is given to an employee for that employee hold.
                        <br/>
                        <br/>
                        So, for every mutation records, we are going to record the asset's information, along with the record
                        of the previous holding employee, and the target holding employee.
                        <br/>
                        <br/>
                        Why do we do it this way? Because in a company, every assets, at any given time, should be held by an
                        employee! There has to be one employee who is responsible of the asset! Otherwise, if no employee is
                        responsible for the asset, that asset is basically gone. No one knows where it is, and no one knows who
                        know where to find it.

                        <blockquote class="blockquote-reverse bg-success col-sm-12">
                            <span class="fa fa-2x fa-quote-left pull-left"></span>
                            Having recorded asset mutations for quite a long time in my workplace, I really think that
                            tracking asset mutations history is more of a matter of being able to find <strong>WHO</strong>
                            is and was responsible for holding a particular asset, rather than <strong>WHERE</strong>.
                            <footer>An IT Staff at my internship workplace (2017)</footer>

                            <div class="clearfix"></div>
                        </blockquote>
                     </p>
                    <hr/>
                </div>

                <div class="col-sm-12" id="assets-location">
                    <h3 >Okay, but how would I know the location of the asset?</h3>
                    <p>
                        Simple, we store the information of every employee's current location. Either the asset will be with
                        the employee, or the employee will be able to point us to where the asset actually is, because, well,
                        the employee is responsible of the assets that s/he holds.
                        <br/>
                        <br/>
                        This allow us to have the ability to not store both the employee's information and the asset's
                        location information everytime a mutation occurs, instead, we only store the employee's information.

                        <img src="<?= base_url().'images/help1.png'?>" class="img-thumbnail img-responsive img-rounded"
                            alt="An example of mutation records."/>
                        <h6><center>
                            <a href="<?= base_url().'images/help1.png'?>" target="_blank">Click here to see full image</a></center></h6>
                    </p>
                    <hr/>
                </div>

                <div class="col-sm-12" id="items-and-assets">
                    <h3>I saw 'item' in the image. Are 'items' and 'assets' the same?</h3>
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
                    <hr/>
                </div>
                <div class="col-sm-12" id="assembled-item">
                    <h3>Desktops? What if one day I will take apart those kind of items?</h3>
                    <p>
                        Worry not! When you create an item type, you can define them as an 'assembled item'.
                        An assembled item can contain unlimited items inside of it.

                        <img src="<?= base_url().'images/help2.png'?>" class="img-thumbnail img-responsive img-rounded"
                             alt="Assembled item."/>
                    <h6><center>
                            <a href="<?= base_url().'images/help2.png'?>" target="_blank">Click here to see full image</a></center></h6>

                    As you might be able to infer from the image above, you can remove item out of an assembled item,
                    and add items into it as well! Items inside can not be mutated individually, but if you mutate
                    the assembled item, every item inside of it will be mutated as well, and the mutation for each
                    of the item will also be recorded individually! This will ensure that you will still have the
                    mutation records even after you remove the item to be an individual item.
                    </p>
                </div>
                <div class="col-sm-12" id="try">
                    <h3>I see... I guess I need to try it out to learn more about it</h3>
                    <p>
                        Glad to hear that! Go on, try!
                    </p>
                </div>

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-primary" style="position: fixed">
            <div class="panel-heading">
                <h3 class="panel-title">Contents</h3>
            </div>
            <div class="panel-body">
                <ul>
                    <li><a href="#what-is-this">What is this?</a></li>
                    <li><a href="#assets">What are assets?</a></li>
                    <li><a href="#mutations">Mutations?</a></li>
                    <li><a href="#assets-location">How can I find assets' location?</a></li>
                    <li><a href="#items-and-assets">Items vs. Assets</a></li>
                    <li><a href="#assembled-item">Assembled items?</a></li>
                    <li><a href="#try">I guess I'll try it then</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>


