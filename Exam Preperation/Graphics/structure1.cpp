#include <GL/glut.h>

void display()
{
  //! Set Backgroud Color - Black
  glClearColor(0.0, 0.0, 0.0, 1.0);
  //! Clear Color Buffur
  glClear(GL_COLOR_BUFFER_BIT);

  //! Draw ----
  // TODO - glBegin(ex - GL_TRIANGLES)
  // code
  // TODO - glEnd();

  //! FLush
  glFlush();
}

int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);

  glutInitWindowSize(500, 500);
  glutCreateWindow("Output Name");

  glutDisplayFunc(display);

  glutMainLoop();

  return 0;
}