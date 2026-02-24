#include <GL/glut.h>

/* ---------------- Window Size ---------------- */
int ww = 600, wh = 600;

/* ---------------- Colors ---------------- */
float fillColor[3] = {1.0, 0.0, 0.0}; // Red (Fill color)
float oldColor[3];                    // Stores original clicked color

/* ---------------- Get Pixel Color ---------------- */
void getPixel(int x, int y, float color[3])
{
  glReadPixels(x, y, 1, 1, GL_RGB, GL_FLOAT, color);
}

/* ---------------- Draw Pixel ---------------- */
void setPixel(int x, int y, float color[3])
{
  glColor3fv(color);
  glBegin(GL_POINTS);
  glVertex2i(x, y);
  glEnd();
  glFlush();
}

/* ---------------- Compare Colors ---------------- */
bool sameColor(float c1[3], float c2[3])
{
  return (c1[0] == c2[0] &&
          c1[1] == c2[1] &&
          c1[2] == c2[2]);
}

/* ---------------- Flood Fill (4-Connected) ---------------- */
void floodFill(int x, int y)
{
  float currentColor[3];
  getPixel(x, y, currentColor);

  if (sameColor(currentColor, oldColor))
  {
    setPixel(x, y, fillColor);

    floodFill(x + 1, y);
    floodFill(x - 1, y);
    floodFill(x, y + 1);
    floodFill(x, y - 1);
  }
}

/* ---------------- Draw Triangle ---------------- */
void display()
{
  glClear(GL_COLOR_BUFFER_BIT);

  // Draw white triangle boundary
  glColor3f(1.0, 1.0, 1.0);
  glBegin(GL_LINE_LOOP);
  glVertex2i(200, 200);
  glVertex2i(400, 200);
  glVertex2i(300, 400);
  glEnd();

  glFlush();
}

/* ---------------- Mouse Function ---------------- */
void mouse(int button, int state, int x, int y)
{
  if (button == GLUT_LEFT_BUTTON && state == GLUT_DOWN)
  {
    y = wh - y; // Convert to OpenGL coordinate

    // Get original color where user clicked
    getPixel(x, y, oldColor);

    // Prevent infinite recursion if already filled
    if (!sameColor(oldColor, fillColor))
    {
      floodFill(x, y);
    }
  }
}

/* ---------------- Initialize ---------------- */
void init()
{
  glClearColor(0.0, 0.0, 0.0, 0.0); // Black background

  glMatrixMode(GL_PROJECTION);
  gluOrtho2D(0, ww, 0, wh);
}

/* ---------------- Main ---------------- */
int main(int argc, char **argv)
{
  glutInit(&argc, argv);
  glutInitDisplayMode(GLUT_SINGLE | GLUT_RGB);
  glutInitWindowSize(ww, wh);
  glutCreateWindow("Flood Fill - Triangle");

  init();
  glutDisplayFunc(display);
  glutMouseFunc(mouse);

  glutMainLoop();
  return 0;
}