/** @jsx React.DOM */

/*
* Posts
* The posts structure should look something like this:
* - PostsContainer
*   - PostList
*     - Post
*/

// The current mode, if true Posts are shown. If false comments are shown
var mode = true;


var PostContainer = React.createClass({
    render: function() {
        return (
            <div className="PostContainer">
                <PostList data={this.props.data} />
            </div>
        );
    }
});

var PostList = React.createClass({
    render: function(){
        var posts = this.props.data.map(function(post){
            var data = post.data;


            //Build the x hours ago thing
            var creation_time = data.created_utc;
            var now = Date.now() / 1000; //Get to the same level of resolution as reddit
            var diff = now - creation_time;

            var minutes = Math.floor(diff / 60);
            var hours = Math.floor(minutes / 60);
            var days = Math.floor(hours/24);
            var years = Math.floor(days/365);

            var time_ago = "";

            if(years >= 1){
                time_ago = years + " years ago";
            }else if(days >= 1){
                time_ago = days + " days ago";
            }else if(hours >= 1){
                time_ago = hours + " hours ago";
            }else if(minutes >= 1){
                time_ago = minutes + " minutes ago";
            }else{ // Not sure if seconds or milli
                time_ago = diff + " seconds ago";
            }

            //console.log(data.title + " posted " + time_ago);

            // If its a self post, change the url to a local one
            var url = data.url;

            return <Post toggle={false} title={data.title} score={data.score} comments={data.num_comments}
                    time={time_ago} subreddit={data.subreddit} is_self={data.is_self} url={url} />;
        });
        return (
            <div className="PostList">
                {/* TODO find a better way of displaying the theres nothing here error */}
                {posts.length > 0 ?  posts : "There's nothing here"}
            </div>
        );
    }
});

var Post = React.createClass({
    render: function(){
        return (
            <div className="reddit-post well hiddable" onclick={this.clicked} >
                <div className="row">
                    <div className="col-md-1 col-sm-2">
                        <div className="text-centered">
                            <div className="btn btn-default">
                                <span className="glyphicon glyphicon-arrow-up"></span>
                            </div>
                            <p>{this.props.score}</p>
                            <div className="btn btn-default">
                                <span className="glyphicon glyphicon-arrow-down"></span>
                            </div>
                        </div>
                    </div>
                    <div className="col-md-11 col-sm-10">
                        <p>
                        {/*TODO: Find a better place for a self post*/}
                        <h3><a className="post-title" href={this.props.url}>{this.props.title}</a> <small>{this.props.is_self ? "Self" : ""}</small></h3>
                        Posted {this.props.time} @/r/{this.props.subreddit}
                        </p>
                    </div>
                </div>
                <div className="row">
                    <div className="col-sm-2 col-sm-offset-1">
                        {this.props.comments} Comments
                    </div>
                    <div className="col-sm-1">
                        Report
                    </div>
                </div>
            </div>
        );
    }
});

// Get the data from the server
$.ajax("/subreddit").done(function(d){
        data = d['data']['children'];
        React.renderComponent(
            <PostContainer data={data} />,
            document.getElementById('container')
        );

        $(".reddit-post").on("click", function(e){

            // Change the tags if we're hiding things to not hide things
            if(mode){
                $(this).addClass("visible");
                $(this).removeClass("hiddable");
            }

            // Show or hide
            $(".hiddable").toggle(500);

            // If showing add the tags after
            if(!mode){
                $(this).removeClass("visible");
                $(this).addClass("hiddable");
            }

            mode = !mode;


            //TODO Add code here to load comments from the server
        });
    });
