<?php

use Illuminate\Database\Seeder;

class ShowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Show::class, 10)->create();
        DB::table('shows')->delete();
        DB::table('shows')->insert([
            ['id' => 1, 
            'name' => "Crazy Ex-Girlfriend", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046656/crazyex_gyuk0t.jpg", 
            'synopsis' => "A young woman abandons a choice job at a law firm and her life in New York in an attempt to find happiness in the unlikely locale of West Covina, California.", 
            'seasons' => 3,
            'status' => "E",
            'netflix' => "https://www.netflix.com/title/80066227",
            'imdb' => "http://www.imdb.com/title/tt4094300/"],

            ['id' => 2, 
            'name' => "Gilmore Girls", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046644/gilmore_pbpdqp.png", 
            'synopsis' => "A dramedy centering around the relationship between a thirtysomething single mother and her teen daughter living in Stars Hollow, Connecticut.", 
            'seasons' => 7,
            'status' => "F",
            'netflix' => "https://www.netflix.com/title/70155618",
            'imdb' => "http://www.imdb.com/title/tt0238784/"],

            ['id' => 3, 
            'name' => "Glee", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046630/glee_dqimfv.jpg", 
            'synopsis' => "A group of ambitious misfits try to escape the harsh realities of high school by joining a glee club, where they find strength, acceptance and, ultimately, their voice, while working to pursue dreams of their own.", 
            'seasons' => 6,
            'status' => "F",
            'netflix' => "https://www.netflix.com/title/70143843",
            'imdb' => "http://www.imdb.com/title/tt1327801/"],

            ['id' => 4, 
            'name' => "Jane The Virgin", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046634/jane_h9rhtc.jpg", 
            'synopsis' => "A young, devout Catholic woman discovers that she was accidentally artificially inseminated.", 
            'seasons' => 4,
            'status' => "E",
            'netflix' => "https://www.netflix.com/title/80027158",
            'imdb' => "http://www.imdb.com/title/tt3566726/"],

            ['id' => 5, 
            'name' => "Orphan Black", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046605/orphan_h3pe2j.jpg", 
            'synopsis' => "A streetwise hustler is pulled into a compelling conspiracy after witnessing the suicide of a girl who looks just like her.", 
            'seasons' => 5,
            'status' => "F",
            'netflix' => "https://www.netflix.com/title/70276033",
            'imdb' => "http://www.imdb.com/title/tt2234222/"],

            ['id' => 6, 
            'name' => "Sense8", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046668/sense_tanwj9.png", 
            'synopsis' => "A group of people around the world are suddenly linked mentally, and must find a way to survive being hunted by those who see them as a threat to the world's order.", 
            'seasons' => 2,
            'status' => "E",
            'netflix' => "https://www.netflix.com/title/80025744",
            'imdb' => "http://www.imdb.com/title/tt2431438/"],

            ['id' => 7, 
            'name' => "Sex and the City", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046616/sex_ukoxxb.jpg", 
            'synopsis' => "Four female New Yorkers gossip about their sex lives (or lack thereof) and find new ways to deal with being a woman in the '90s.", 
            'seasons' => 6,
            'status' => "F",
            'netflix' => "",
            'imdb' => "http://www.imdb.com/title/tt0159206/"],

            ['id' => 8, 
            'name' => "Shadowhunters", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046681/shadow_ftliy6.png", 
            'synopsis' => "After her mother disappears, Clary must venture into the dark world of demon hunting, and embrace her new role among the Shadowhunters.", 
            'seasons' => 2,
            'status' => "E",
            'netflix' => "https://www.netflix.com/title/80084447",
            'imdb' => "http://www.imdb.com/title/tt4145054/"],

            ['id' => 9, 
            'name' => "The Big Bang Theory", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046725/bigbang_uu1caj.jpg", 
            'synopsis' => "A woman who moves into an apartment across the hall from two brilliant but socially awkward physicists shows them how little they know about life outside of the laboratory.", 
            'seasons' => 11,
            'status' => "E",
            'netflix' => "https://www.netflix.com/title/70143830",
            'imdb' => "http://www.imdb.com/title/tt0898266/"],

            ['id' => 10, 
            'name' => "The Handmaid's Tale", 
            'poster' => "http://res.cloudinary.com/ht0shxjqw/image/upload/c_scale,w_310/v1513046610/handmaids_mwr47l.jpg", 
            'synopsis' => "Set in a dystopian future, a woman is forced to live as a concubine under a fundamentalist theocratic dictatorship.", 
            'seasons' => 1,
            'status' => "E",
            'netflix' => "",
            'imdb' => "http://www.imdb.com/title/tt5834204/"],
            ]);
    }
}