<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8"/>
		<!-- add a CSS file -->
		<!--<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />-->
		<title>AllRecipes Data Design</title>
	</head>
	<body>
		<!-- Header information -->
		<header>
			<h1>Data Design Project - Allrecipes</h1>
		</header>

		<!-- Content goes here -->
		<main>
			<!-- begin section 1 -->
			<section>
				<h1>Persona</h1>
				<ul>
					<li><b>Name:</b> James O'Brien</li>
					<li><b>Age:</b> 42</li>
					<li><b>Attitudes and Behaviors:</b> James likes good food, enjoys eating, and enjoys cooking. He likes researching the cooking experience, looking for new recipes to try. He enjoys sharing food with and cooking for others. He may spend a substantial amount of time looking for a great recipe to impress his friends and family, or just for himself.</li>
					<li><b>Technology:</b> James ejoys spending time online, but he does not have the most up-to-date software/computer system.</li>
					<li><b>Frustrations and Needs:</b> James likes recipes to be easy to read and to search. He wants to be able to read reviews in order to get an idea of how successful a recipe will be (in addition to author's comments describing the outcome).</li>
					<li><b>Goals:</b>James likes to share recipes he has developed or modified with others. He likes recieving 5-star reviews on creations that are particularly successful. He wants to be able to easily share recipes he has created with friends, family, and co-workers (via email/social media). James likes to find new recipes and try new ideas and techniques, and working with new tastes.</li>
				</ul>
			</section>
			<section>
				<h1>Use Case</h1>
				<!-- Use case should contain the following info:
				<p>Main Goal</p>
				<p>Who</p>
				<p>What</p>
				<p>Where</p>
				<p>What Technology</p>
				-->
				<p>James is a little bored with his usual go-to recipes. He is cooking a big meal Saturday for his family, and would like to try something new. He has browsed through a list of currently popular recipes, and he has searched for pork shoulder in ingredients because he thinks that will be particularly tasty. He has narrowed down his ideas to a single recipe he would like to try. He has taken a look at the ingredients he thinks he will need. Sometimes he likes to print out the recipe, but usually he just keeps it open on his ipad. He has made a grocery list and picked up most of the ingredients, but forgot to get one of the spices needed. He scrolls thorugh the comments to see if any reviewers have replaced it, or done without. He cooks it up. His family loves it, and so does he! The leftovers tase great, and he is quite thrilled, so he leaves a comment about how it works well even with some modifications, and a 5-star review for the author.</p>
			</section>
			<section>
				<h1>Interaction Flow</h1>
			</section>
			<section>
				<h1>Conceptual Model</h1>
					<ul>
						<li><b>Photos</b>
							<ul>
								<li>imageId (primary key)</li>
								<li>imageFile</li>
								<li>recipeId (foreign key)</li>
							</ul>
						</li>
						<li><b>Recipe</b>
							<ul>
								<li>ingredients list (separate into its own table to be able to cross-reference in ingredient?)</li>
								<li>directions</li>
								<li>recipeId (primary key)</li>
								<li>userId (foreign key)</li>
								<li>prepTime</li>
								<li>cookTime</li>
								<li>footnotes</li>
							</ul>
						</li>
						<li><b>Comments</b>
							<ul>
								<li>commentId (primary key)</li>
								<li>rating (number of stars)</li>
								<li>userId</li>
								<li>commentText</li>
								<li>recipeId (foreign key)</li>
							</ul>
						</li>
						<li><b>Profile</b>
							<ul>
								<li>userId (primary key)</li>
								<li>emailAddress</li>
								<li>avatarId</li>
							</ul>
						</li>
					</ul>


			</section>
		</main>
	</body>
</html>