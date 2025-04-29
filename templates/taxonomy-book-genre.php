<?php get_header(); ?>

<?php $genre = get_queried_object(); ?>

<div id="content" class="container" role="main">

  <h2 class="genre-title">
    <?php echo esc_html__('Genre: ', 'twentytwenty-child') . esc_html($genre->name); ?>
  </h2>

  <section class="book-list-wrap container">

    <div class="book-genre-list">
      <h3><?php esc_html_e('Genres', 'twentytwenty-child'); ?></h3>
      <ul class="book-genres list">
        <?php 
          $terms = get_terms(array(
            'taxonomy' => 'book-genre',
            'hide_empty' => false
          ));
          foreach($terms as $term) {
            $isActive = $genre->term_id === $term->term_id ? 'active' : '';
            echo '<li class="' . esc_attr($isActive) . '"><a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a></li>';
          }
        ?>
      </ul>
    </div>

    <div class="book-list">

      <?php 
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        $args = array(
          'post_type' => 'library',
          'posts_per_page' => 5,
          'paged' => $paged,
          'tax_query' => array(
            array(
              'taxonomy' => 'book-genre',
              'field'    => 'term_id',
              'terms'    => $genre->term_id,
            ),
          ),
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) : ?>
          <ul class="book-list-items list">
            <?php while($query->have_posts()) : $query->the_post(); ?>
              <li class="book-item">
                <a href="<?php the_permalink(); ?>">
                  <?php if (has_post_thumbnail()) : ?>
                    <div class="book-cover"><?php the_post_thumbnail('medium'); ?></div>
                  <?php endif; ?>
                  <h3 class="book-title"><?php the_title(); ?></h3>
                </a>
              </li>
            <?php endwhile; ?>
          </ul>

          <div class="pagination">
            <?php 
              $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;  
              echo paginate_links(array(
                'base' => get_pagenum_link() . '%_%',        
                'format' => 'page/%#%',
                'total' => $query->max_num_pages,
                'prev_text'    => __('« previous'),
                'next_text'    => __('next »'),
                'page' => $paged
              ));
            ?>
          </div>

        <?php else : ?>
          <p><?php esc_html_e('No books found in this genre.', 'twentytwenty-child'); ?></p>
        <?php endif; ?>

      <?php wp_reset_postdata(); ?>

    </div>

  </section>

</div>

<?php get_footer(); ?>