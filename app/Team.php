<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Team extends Model
{
    /**
     * Fillables for the database
     *
     * @access protected
     * @var    array $fillable
     */
    protected $fillable = array(
        'slug', 'employer_id'
    );

    /**
     * Protected Date
     *
     * @access protected
     * @var    array $dates
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The users that belong to the team.
     *
     * @return relation
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /** 
     * Set slug before saving in DB
     *
     * @param string $value value
     *
     * @access public
     *
     * @return string
     */
    public function setSlugAttribute($value)
    {
        if (!empty($value)) {
            $temp = str_slug($value, '-');
            if (!Team::all()->where('slug', $temp)->isEmpty()) {
                $i = 1;
                $new_slug = $temp . '-' . $i;
                while (!Team::all()->where('slug', $new_slug)->isEmpty()) {
                    $i++;
                    $new_slug = $temp . '-' . $i;
                }
                $temp = $new_slug;
            }
            $this->attributes['slug'] = $temp;
        }
    }

    /**
     * Add team
     *
     * @param $request
     * @return array
     */
    public function addTeam($request){
        $json = [];

        if (!empty($request)) {
            $this->name = $request->name;
            $this->description = $request->description;
            $this->slug = filter_var($request->name, FILTER_SANITIZE_STRING);
            $this->employer_id = Auth::user()->id;
            $this->save();
            $json['type'] = "success";

            return $json;
        } else{
            $json['type'] = "error";

            return $json;
        }
    }

    /**
     * Update team
     *
     * @param $request
     * @return array
     */
    public function updateTeam($request){
        $json = [];

        if (!empty($request)) {
            $team = Team::find($request->id);
            $team->name = $request->name;
            $team->description = $request->description;
            $team->slug = filter_var($request->name, FILTER_SANITIZE_STRING);
            $team->employer_id = Auth::user()->id;
            $team->save();
            $json['type'] = "success";

            return $json;
        } else{
            $json['type'] = "error";

            return $json;
        }
    }

    public function addMember($request){
        $json = [];

        if(!empty($request)){
            $team = Team::where('slug', $request->slug)->first();
            $team->users()->attach($request->freelancer_id);

            $json['type'] = "success";
            return $json;
        }else{
            $json['type'] = "error";
            return $json;
        }
    }

    public function deleteMember($request){
        $json = [];

        if(!empty($request)){
            $team = Team::where('slug', $request->slug)->first();
            $team->users()->detach($request->freelancer_id);

            $json['type'] = "success";
            return $json;
        }else{
            $json['type'] = "error";
            return $json;
        }
    }
}
