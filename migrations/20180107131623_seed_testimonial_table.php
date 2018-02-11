<?php

use Phinx\Migration\AbstractMigration;

class SeedTestimonialTable extends AbstractMigration
{
    public function up()
    {
        $this->execute("
            insert into testimonials (title, testimonial, user_id, created_at)
            values
            ('Testimonial Title', 'Testimonial text', 1, '2018-01-07 13:16:23')
        ");
    }

    public function down()
    {

    }
}
